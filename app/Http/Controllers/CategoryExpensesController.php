<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Expenses_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkPermission = $this->checkPermission(auth()->user()->id, 'Voir la liste des catégories de dépenses');
        if ($checkPermission == false) {
            return redirect()->back()->with('errors', "Vous n'avez pas la permission de Voir la liste des catégories de dépenses.");
        }

        $categories = DB::table('expenses_categories')->get();
        Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a visité la liste des catégories de dépenses');
        return view('expenses_category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Créer une catégorie de dépense');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Créer une catégorie de dépense.");
            }

            $validator = Validator::make($request->only(['label_categorie']), [
                'label_categorie' => ['required', 'min:2', 'max:50', 'string', 'unique:expenses_categories,label']
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $expenses_category = DB::table('expenses_categories')->insert([
                'label' => $request->label_categorie
            ]);
            if ($expenses_category) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a créé une catégorie de dépenses');
                return redirect()->route('categ_expenses.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de créer une catégorie de dépenses sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        die($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = DB::table('expenses_categories')->where('id', $id)->first();
        return view('expenses_category.edit', ['categorie' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Modifier une catégorie de dépense');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Modifier une catégorie de dépense.");
            }

            $validator = Validator::make($request->only(['label_categorie']), [
                'label_categorie' => ['required', 'min:2', 'max:50', 'string']
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $expenses_categorie = DB::table('expenses_categories')->where('id', $id)->update([
                'label' => $request->label_categorie
            ]);
            if ($expenses_categorie) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifié une catégorie de dépenses');
                return redirect()->route('categ_expenses.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de modifier une catégorie de dépenses sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses_category $category)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Supprimer une catégorie de dépense');
            if ($checkPermission == false) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer une catégorie de dépenses sans succès');
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Supprimer une catégorie de dépense.");
            }

            if ($category) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a supprimé une catégorie de dépenses');
                $category->delete();
                return redirect()->back()->with('success', 'Catégorie de dépense supprimé avec succes.');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer une catégorie de dépenses sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }
}
