<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        return view('materiels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
            ]);

            $materiel = Material::create($request->all());
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
        $materiel = Material::findOrFail($id);
        return view('materiels.edit', compact('materiel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'nullable',
            ]);

            $material = Material::findOrFail($id);

            if ($material) {
                $material->update($request->all());
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
