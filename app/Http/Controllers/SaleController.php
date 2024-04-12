<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Material;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::all();
        Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a visité la liste des ventes/sorties');
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $drugs = Drug::all();
        return view('sales.create', compact('drugs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'item_type' => 'required|string',
            'drug' => 'nullable|numeric',
            'quantity' => 'numeric|required',
            'sale_date' => 'string|required',
            'sale_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors());
        }
        // dd($request->drug);
        
        
        // Implement FIFO logic for stock movement
        $quantityRemaining = $request->quantity;
        
        while ($quantityRemaining > 0) {
            $stockEntry = StockMovement::where('item_type', 'product')
            ->where('item_id', $request->drug)
            ->where('type', 'entry')
            ->orderBy('movement_date', 'asc')
            ->first();
            
            // dd($stockEntry->quantity);
            
            if (!$stockEntry) {
                return redirect()->back()->with('errors', 'Le stock est insuffisant.');
            }
            
            
            $availableQuantity = $stockEntry->quantity;
            $quantityToDeduct = min($availableQuantity, $quantityRemaining);
            
            // Update or create stock movement for the sale
            $movement = StockMovement::create([
                'type' => 'exit',
                'item_type' => 'product',
                'item_id' => $request->drug,
                'quantity' => $quantityToDeduct,
                'movement_date' => $request->sale_date,
            ]);
            
            $quantityRemaining -= $quantityToDeduct;

            if ($movement) {
                $sale = Sale::create([
                    'drug_id' => $request->drug,
                    'quantity' => $request->quantity,
                    'sale_price' => $request->sale_price,
                    'sale_date' => $request->sale_date
                ]);
                
                Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une sortie du produit '. $sale->drug->name );
                
            }
            
            // If the entry is fully consumed, delete it; otherwise, update the quantity
            if ($availableQuantity == $quantityToDeduct) {
                $stockEntry->delete();
            } else {
                $stockEntry->quantity -= $quantityToDeduct;
                $stockEntry->save();
            }
        }
        
        return redirect()->back()->with('status', 'Sortie effectuée avec succes');
    } catch (\Throwable $th) {
        Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de faire sortie le produit '. $sale->drug->name .' sans succès');
        return redirect()->back()->with('errors', $th->getMessage());

    }

    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function fiche_stock(){
        $drugs = Drug::all();
        $materials = Material::all();
        $stockMovements = StockMovement::orderBy('movement_date', 'asc')->get();
        Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a visité la fiche de stock');
        return view('stock.fiche', compact('stockMovements', 'materials', 'drugs'));
    }
    
    public function fiche_fifo_product($id){
        
        $drugs = Drug::all();
        $materials = Material::all();
        $sales = Sale::where('drug_id', $id)->get();
        $purchases = Purchase::where('drug_id', $id)->get();
        $stockMovements = StockMovement::where('item_type', 'product')->where('item_id',$id)->orderBy('movement_date', 'asc')->get();
        return view('stock.fiche_fifo', compact('stockMovements', 'sales', 'purchases', 'materials', 'drugs'));
    }

    public function fiche_fifo_materiel(){
        return view('stock.fiche_fifo');
    }
}
