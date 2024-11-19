<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Typemateriel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materiels = Material::all();
        Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a visité la liste des matériels');
        return view('materiels.index', compact('materiels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Typemateriel::all();
        return view('materiels.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //code...
            $validator = Validator::make($request->only('name', 'currentStock', 'alertStock', 'description', 'magStock', 'type_mat') ,[
                'name' => 'required|string',
                'currentStock' => 'required|numeric',
                'alertStock' => 'required|numeric',
                'magStock' => 'required|numeric',
                'description' => 'required|string',
                'type_mat' => 'required|numeric',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }
            // dd($request->currentStock);


            $materiel = Material::create([
                'name' => $request->name,
                'currentStock' => $request->currentStock,
                'alertStock' => $request->alertStock,
                'stockMag' => $request->magStock,
                'description' => $request->description,
                'type_id' => $request->type_mat
            ]);
            if ($materiel) {
                Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a ajouté le médicament ' . $request->name);
                return redirect()->route('materiels.index')->with('success', 'Matériel ajouté avec succès.');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé d\'ajouter le matériel ' . $request->name . 'sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $material = Material::findOrFail($id);
        return view('materiels.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $types = Typemateriel::all();
        $materiel = Material::findOrFail($id);
        return view('materiels.edit', compact('materiel', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->only('name', 'currentStock', 'alertStock', 'description', 'magStock', 'type_mat') ,[
                'name' => 'nullable|string',
                'currentStock' => 'nullable|numeric',
                'alertStock' => 'nullable|numeric',
                'magStock' => 'nullable|numeric',
                'type_mat' => 'nullable|numeric',
                'description' => 'nullable|string',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }
            // dd($request->currentStock);


            $material = Material::findOrFail($id);

            if ($material) {
                $material->update([
                    'name' => $request->name,
                    'currentStock' => $request->currentStock,
                    'alertStock' => $request->alertStock,
                    'stockMag' => $request->magStock,
                    'description' => $request->description,
                    'type_id' => $request->type_mat]);
                Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifié le matériel ' . $request->name);
                return redirect()->route('materiels.index')->with('success', 'Matériel modifié avec succès');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de modifier le matériel ' . $request->name . ' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            //code...
            $material = Material::findOrFail($id);
            if ($material) {
                Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifié le matériel ' . $material->name);
                $material->delete();
                return redirect()->route('materiels.index')->with('success', 'Matériel supprimé avec succès');
            }
            
        } catch (\Throwable $th) {
            Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer le matériel '. $material->name.' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
        
    }
}
