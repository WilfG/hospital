<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseRequest;
use App\Models\Expenses_category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkPermission = $this->checkPermission(auth()->user()->id, 'Voir la liste des dépenses');
        if ($checkPermission == false) {
            return redirect()->back()->with('errors', "Vous n'avez pas la permission de Voir la liste des dépenses.");
        }

        $expenses = DB::table('expenses')
            ->join('expense_requests', 'expenses.request_id', 'expense_requests.id')
            ->join('users', 'expense_requests.user_id', 'users.id')
            ->join('expenses_categories', 'expenses.expenses_category_id', 'expenses_categories.id')
            ->get(['expenses.*', 'expense_requests.*', 'users.lastname', 'users.firstname', 'expenses_categories.label']);
        Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a visité la liste des dépenses');
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($req)
    {
        $categories = DB::table('expenses_categories')->get();
        $reqExpense = ExpenseRequest::find($req);
        return view('expenses.create', ['categories' => $categories, 'reqExpense' => $reqExpense]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Enregistrer une dépense');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission d'Enregistrer une dépense.");
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
                ];

                // Get the MIME type of the file
                $fileMimeType = $value->getClientMimeType();

                // Check if the MIME type is in the list of allowed MIME types
                return in_array($fileMimeType, $allowedMimeTypes);
            });

            $validator = Validator::make($request->only(['reqExpense', 'label_categorie', 'justificatif']), [
                'label_categorie' => ['required', 'string'],
                'reqExpense' => ['required', 'numeric'],
                'justificatif' => 'required|file|custom_file_type'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $path = $request->hasFile('justificatif') ? $request->file('justificatif')->store('depenses', 'public') : null;
            $expense = Expense::create([
                'justificatif' => $path,
                'request_id' => $request->reqExpense,
                'expenses_category_id' => $request->label_categorie,

            ]);
            
            if ($expense) {
                $reqExpense = ExpenseRequest::findOrFail($request->reqExpense)->update([
                    'status' => 'very_completed'
                ]);
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une dépense');
                return redirect()->route('expenses.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de créer une dépense sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $categories = Expenses_category::all();
        $users = User::all();
        return view('expenses.edit', ['expense' => $expense, 'categories' => $categories, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        try {

            $checkPermission = $this->checkPermission(auth()->user()->id, 'Modifier une dépense');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Modifier une dépense.");
            }
            $validator = Validator::make($request->only(['label_categorie', 'reason', 'amount', 'expense_date', 'auteur_id', 'note']), [
                'label_categorie' => ['required', 'string'],
                'reqExpense' => ['required', 'numeric'],
                'justificatif' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            if ($request->hasFile('justificatif')) {
                $path = $request->file('justificatif')->store('depenses', 'public');
                $expense = Expense::create([
                    'justificatif' => $path,
                    'request_id' => $request->reqExpense,
                    'expenses_category_id' => $request->label_categorie,

                ]);
            } else {
                # code...
                $expense = Expense::create([
                    'request_id' => $request->reqExpense,
                    'expenses_category_id' => $request->label_categorie,

                ]);
            }

            if ($expense) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifié une dépense');
                return redirect()->route('expenses.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de modifier une dépense sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Supprimer une dépense');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Supprimer une dépense.");
            }

            if ($expense) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a supprimé la requête de dépense ' . $expense->code);
                $expense->delete();
                return redirect()->back()->with('success', 'Dépense supprimée avec succes.');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer la requête de dépense ' . $expense->code . ' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }
}
