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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
        $validations = Validation::all();
        $expensesReq = ExpenseRequest::all();
        return view('expense_requests.index', compact('expensesReq', 'validations'));
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
                return redirect()->back()->with('errors', "Vous n'avez pas la permission d'Enregistrer une demande de dépense.");
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
            $requestValidators = DB::table('permissions')
                ->join('permission_role', 'permissions.id', 'permission_role.permission_id')
                ->join('roles', 'permission_role.role_id', 'roles.id')
                ->join('users', 'roles.id', 'users.role_id')
                ->where('permissions.label_permission', 'Valider une demande de dépense')
                ->get(['permission_role.role_id']);

            // dd($requestValidators);

            $note = $request->note ? $request->note : null;
            $expenseReq = ExpenseRequest::create([
                'amount' => $request->amount,
                'reason' => $request->reason,
                'note' => $note,
                // 'expenses_category_id' => $request->label_categorie,
                'user_id' => $request->auteur_id,
                'expense_date' => $request->expense_date

            ]);

            if ($expenseReq) {
                foreach ($requestValidators as $key => $value) {
                    $user = User::where('role_id', $value->role_id)->first();
                    $email = $user->email;
                    $name = $user->lastname . ' ' . $user->firstname;
                    $subject = auth()->user()->firstname . ' ' . auth()->user()->firstname . " a fait une Requete de depense";
                    Mail::send(
                        'email.expense_request',
                        ['name' => $name],
                        function ($mail) use ($email, $name, $subject) {
                            $mail->from(getenv('MAIL_FROM_ADDRESS'), "Artfric");
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
                return redirect()->route('expenses_requests.index');
            }
        } catch (\Throwable $th) {
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
                return redirect()->route('expenses_requests.index');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Supprimer une demande de dépense');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Supprimer une dépense.");
            }
            $expenseReq = ExpenseRequest::find($id);

            if ($expenseReq) {
                $expenseReq->delete();
                return redirect()->back()->with('success', 'Demande de Dépense supprimée avec succes.');
            }
        } catch (\Throwable $th) {
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
                $validate_request->status = 'completed';
                $validate_request->save();
                return redirect()->back()->with('success', 'Demande de Dépense validée avec succes.');
            } else {
                $validate = Validation::where('to_be_validated', $request->to_be_vldt)
                    ->where('user_id', $request->vldtor)->first();

                $validate->status = 1;
                $validate->save();
                if ($validate) {
                    return redirect()->back()->with('success', "Vous avez validé la demande d'enregistrement de dépense, en attente des autres validateurs.");
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
}
