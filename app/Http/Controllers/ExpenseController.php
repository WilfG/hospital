<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Expenses_category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $expenses = Expense::all();
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = DB::table('expenses_categories')->get();
        $users = DB::table('users')->get();
        return view('expenses.create', ['categories' => $categories, 'users' => $users]);
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

            $validator = Validator::make($request->only(['label_categorie', 'reason', 'amount', 'expense_date', 'auteur_id', 'note']), [
                'label_categorie' => ['required', 'string'],
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
            $expense = Expense::create([
                'amount' => $request->amount,
                'reason' => $request->reason,
                'note' => $note,
                'expenses_category_id' => $request->label_categorie,
                'user_id' => $request->auteur_id,
                'expense_date' => $request->expense_date

            ]);

            if ($expense) {
                return redirect()->route('expenses.index');
            }
        } catch (\Throwable $th) {
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
            $expense->update([
                'amount' => $request->amount,
                'reason' => $request->reason,
                'note' => $note,
                'expenses_category_id' => $request->label_categorie,
                'user_id' => $request->auteur_id,
                'expense_date' => $request->expense_date

            ]);

            if ($expense) {
                return redirect()->route('expenses.index');
            }
        } catch (\Throwable $th) {
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
                $expense->delete();
                return redirect()->back()->with('success', 'Dépense supprimée avec succes.');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }
}
