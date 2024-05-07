<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRequest;
use App\Models\Expenses_category;
use App\Models\Permission;
use App\Models\User;
use App\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ExpenseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkPermission = $this->checkPermission(auth()->user()->id, 'Voir la liste des demandes de dépenses');
        if ($checkPermission == false) {
            return redirect()->back()->with('errors', "Vous n'avez pas la permission de Voir la liste des dépenses.");
        }

        $requestValidators = DB::table('permissions')
            ->join('permission_role', 'permissions.id', 'permission_role.permission_id')
            ->join('roles', 'permission_role.role_id', 'roles.id')
            ->join('users', 'roles.id', 'users.role_id')
            ->where('permissions.label_permission', 'Valider une demande de dépense')
            ->get(['permission_role.role_id']);
        $canValidate = false;
        foreach ($requestValidators as $key => $value) {
            // $user = User::where('role_id', $value->role_id)->first();
            if (auth()->user()->role_id == $value->role_id) {
                $canValidate = true;
                break;
            }
        }
        // dd($canValidate);

        $validations = Validation::all();
        $expensesReq = ExpenseRequest::all();
        return view('expense_requests.index', compact('expensesReq', 'validations', 'canValidate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = DB::table('expenses_categories')->get();
        $users = DB::table('users')->get();
        return view('expense_requests.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'créer une demande de dépense');
            if ($checkPermission == false) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer une requete de dépenses sans succès');
                return redirect()->back()->with('errors', "Vous n'avez pas la permission d'Enregistrer une demande de dépense.");
            }

            Validator::extend('custom_file_type', function ($attribute, $value, $parameters, $validator) {
                // Define allowed MIME types for images and documents
                $allowedMimeTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // for .docx
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // for .docx
                ];

                // Get the MIME type of the file
                $fileMimeType = $value->getClientMimeType();

                // Check if the MIME type is in the list of allowed MIME types
                return in_array($fileMimeType, $allowedMimeTypes);
            });
            // dd($request->file('justificatif_req'));

            $validator = Validator::make($request->only(['reason', 'amount', 'expense_date', 'auteur_id', 'note', 'justificatif_req']), [
                // 'label_categorie' => ['required', 'string'],
                'reason' => ['required', 'min:2', 'max:100', 'string'],
                'amount' => ['required', 'numeric'],
                'auteur_id' => ['required', 'numeric'],
                'expense_date' => ['required', 'string'],
                'note' => ['nullable', 'string'],
                'justificatif_req' => 'required|file|custom_file_type',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }
            $requestValidators = DB::table('permissions')
                ->join('permission_role', 'permissions.id', 'permission_role.permission_id')
                ->join('roles', 'permission_role.role_id', 'roles.id')
                ->join('users', 'roles.id', 'users.role_id')
                ->where('permissions.label_permission', 'Valider une demande de dépense')
                ->get(['permission_role.role_id']);

            // dd($requestValidators);
            $code = strtoupper('RD-' . Str::random(3));
            $note = $request->note ? $request->note : null;
            $path = $request->hasFile('justificatif_req') ? $request->file('justificatif_req')->store('req_expense', 'public') : null;
            $expenseReq = ExpenseRequest::create([
                'amount' => $request->amount,
                'reason' => $request->reason,
                'note' => $note,
                'justificatif_req' => $path,
                'code' => $code,
                'user_id' => $request->auteur_id,
                'expense_date' => $request->expense_date

            ]);

            if ($expenseReq) {

                foreach ($requestValidators as $key => $value) {
                    $code = $expenseReq->code;
                    $user = User::where('role_id', $value->role_id)->first();
                    $email = $user->email;
                    $name = $user->lastname . ' ' . $user->firstname;
                    $subject = auth()->user()->firstname . ' ' . auth()->user()->lastname . " a créé la requête de depense " . $expenseReq->code;
                    Mail::send(
                        'email.expense_request',
                        ['name' => $name, 'code' => $code, 'expenseReq' => $expenseReq],
                        function ($mail) use ($email, $name, $subject) {
                            $mail->from(getenv('MAIL_FROM_ADDRESS'), "Hopital St Antoine Antoine de Padoue");
                            $mail->to($email, $name);
                            $mail->subject($subject);
                        }
                    );
                    $validation = Validation::create([
                        'type' => 'Demande de depense',
                        'to_be_validated' => $expenseReq->id,
                        'user_id' => $user->id,
                    ]);
                }
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une requête de dépense');

                return redirect()->route('expenses_requests.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de créer une requête de depense sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseRequest $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $expenseReq = ExpenseRequest::find($id);
        $users = User::all();
        return view('expense_requests.edit', ['expenseReq' => $expenseReq, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {

            $checkPermission = $this->checkPermission(auth()->user()->id, 'Modifier une demande de dépense');
            if ($checkPermission == false) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de modifier la requête de dépense ' . ExpenseRequest::find($id)->code . ' sans succès');
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Modifier une dépense.");
            }
            $validator = Validator::make($request->only(['reason', 'amount', 'expense_date', 'auteur_id', 'note']), [
                // 'label_categorie' => ['required', 'string'],
                'reason' => ['required', 'min:2', 'max:100', 'string'],
                'amount' => ['required', 'numeric'],
                'auteur_id' => ['required', 'numeric'],
                'expense_date' => ['required', 'string'],
                'note' => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }
            $note = $request->note ? $request->note : null;

            $expenseReq = ExpenseRequest::find($id);
            $expenseReq->amount = $request->amount;
            $expenseReq->reason = $request->reason;
            $expenseReq->note = $note;
            $expenseReq->user_id = $request->auteur_id;
            $expenseReq->expense_date = $request->expense_date;
            $expenseReq->save();

            if ($expenseReq) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifié la requête de dépense ' . $expenseReq->code);
                return redirect()->route('expenses_requests.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de modifier la requête de dépense ' . $expenseReq->code . ' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $expenseReq = ExpenseRequest::find($id);
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Supprimer une demande de dépense');
            if ($checkPermission == false) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer la requête de dépense ' . $expenseReq->code . ' sans succès');
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Supprimer une dépense.");
            }

            if ($expenseReq) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a supprimé la requête de dépense ' . $expenseReq->code);
                $expenseReq->delete();
                return redirect()->back()->with('success', 'Requête de Dépense supprimée avec succes.');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer la requête de dépense ' . $expenseReq->code . ' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    public function validateExpense(Request $request)
    {
        try {
            $validator = Validator::make($request->only(['to_be_vldt', 'vldtor']), [
                // 'label_categorie' => ['required', 'string'],
                'vldtor' => ['required', 'numeric'],
                'to_be_vldt' => ['required', 'numeric'],

            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }
            // dd($request);

            $validation_table = Validation::where('to_be_validated',  $request->to_be_vldt)
                ->where('user_id',  $request->vldtor)
                ->where('type', 'Demande de depense')
                ->get(['status']);
            $verify = $this->allValuesEqualToOne($validation_table);
            if ($verify) {
                $validate_request = ExpenseRequest::find($request->to_be_vldt);
                $author_id = $validate_request->user_id;
                $validate_request->status = 'completed';
                $validate_request->save();

                $user = User::where('id', $author_id)->first();
                $email = $user->email;
                $name = $user->lastname . ' ' . $user->firstname;
                $subject = auth()->user()->firstname . ' ' . auth()->user()->lastname . " a valide votre requête";
                Mail::send(
                    'email.expense_request',
                    ['name' => $name],
                    function ($mail) use ($email, $name, $subject) {
                        $mail->from(getenv('MAIL_FROM_ADDRESS'), "HOPITAL SAINT ANTOINE DE PADOUE");
                        $mail->to($email, $name);
                        $mail->subject($subject);
                    }
                );
                return redirect()->back()->with('success', 'Requête de Dépense validée avec succes.');
            } else {
                $validate = Validation::where('to_be_validated', $request->to_be_vldt)
                    ->where('user_id', $request->vldtor)->first();

                $validate->status = 1;
                $validate->save();
                if ($validate) {
                    return redirect()->back()->with('success', "Vous avez validé la requête d'enregistrement de dépense, en attente des autres validateurs.");
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }
    function allValuesEqualToOne(Collection $collection): bool
    {
        return $collection->every(function ($value) {
            return $value->status == 1;
        });
    }

    public function download($id)
    {
        // File to be downloaded
        $file = ExpenseRequest::find($id)->justificatif_req;
        echo '/storage/' . $file;
        exit;
        // if (Storage::disk('public')->exists($file)) {
        //     // echo $file;
        //     // exit;
        //     // The file exists
        //     $fileName = basename($file);
        //     $headers = ['Content-Type: application/pdf'];

        //     return Storage::download($file, null, $headers);
        // }
        // return redirect()->back()->with('errors', "Le fichier n'existe pas");
    }
}
