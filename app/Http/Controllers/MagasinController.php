<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Magasin;
use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MagasinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements= Magasin::with('material')->get();
        // dd($movements);
        return view('magasins.movements_mat', compact('movements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function stockMovementsMats(){
        $users = User::all();
        $drugs = Drug::all();
        $materials = Material::all();
        $stockMovementsMats = StockMovement::where('item_type', 'material')->orderBy('movement_date', 'asc')->get();
        // dd($stockMovementsMats);
        Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a visité la fiche de stock');
        return view('magasins.fiche_materiel', compact('stockMovementsMats', 'materials', 'drugs', 'users'));
    
    }
}
