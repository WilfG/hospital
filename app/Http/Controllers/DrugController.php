<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DrugController extends Controller
{

    public function index()
    {
        $drugs = Drug::all();
        Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a visité la liste des produits');
        return view('drugs.index', compact('drugs'));
    }

    public function create()
    {
        return view('drugs.create');
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        try {
            //code...
            $validator = Validator::make($request->only('name', 'currentStock', 'alertStock', 'description') ,[
                'name' => ['required', 'min:2', 'max:100', 'unique:drugs,name'],
                'currentStock' => 'required|numeric',
                'alertStock' => 'required|numeric',
                'magStock' => 'required|numeric',
                'description' => 'required|string',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }
            // dd($request->currentStock);

            $drug = Drug::create([
                'name' => $request->name,
                'currentStock' => $request->currentStock,
                'alertStock' => $request->alertStock,
                'stockMag' => $request->magStock,
                'description' => $request->description
            ]);

            if ($drug) {
                Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a ajouté le produit ' . $request->name);
                return redirect()->route('drugs.index')->with('success', 'Médicament ajouté avec succes.');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé d\'ajouter le produit ' . $request->name . 'sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    public function show($id)
    {
        $product = Drug::findOrFail($id);
        return view('drugs.edit', compact('product'));
    }

    public function edit($id)
    {
        $drug = Drug::findOrFail($id);
        return view('drugs.edit', compact('drug'));
    }

    public function update(Request $request, $id)
    {
        try {
            //code...
            $validator = Validator::make($request->only('name', 'currentStock', 'alertStock', 'description') ,[
                'name' => 'required|string',
                'currentStock' => 'required|numeric',
                'alertStock' => 'required|numeric',
                'description' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }
           // dd($request->description);
            $product = Drug::findOrFail($id);

            if ($product) {
                $product->update($request->all());
                Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifié le produit ' . $request->name);
                return redirect()->route('drugs.index')->with('success', 'Produit modifié avec succès');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de modifier le produit ' . $request->name .' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Drug::findOrFail($id);
            if ($product) {
                Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifié le produit ' . $product->name);
                $product->delete();
                return redirect()->route('drugs.index')->with('success', 'Produit supprimé avec succès');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer le produit '. $product->name.' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }
}
