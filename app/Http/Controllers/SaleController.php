<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Material;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

                $item = Drug::where('id', $request->drug)->first();
                // dd($item);

                if ($item->currentStock < $request->quantity) {
                    return redirect()->back()->with('errors', 'Le stock est insuffisant.');
                }


                $availableQuantity = $item->currentStock;
                $quantityToDeduct = min($availableQuantity, $quantityRemaining);

                $sale = Sale::create([
                    'drug_id' => $request->drug,
                    'quantity' => $request->quantity,
                    'sale_price' => $request->sale_price,
                    'sale_date' => $request->sale_date
                ]);

                if ($sale) {
                    // Update or create stock movement for the sale
                    $movement = StockMovement::create([
                        'type' => 'exit',
                        'item_type' => 'product',
                        'item_id' => $request->drug,
                        'quantity' => $quantityToDeduct,
                        'movement_date' => $request->sale_date,
                        'sale_id' => $sale->id,
                        'author' => auth()->user()->id,
                    ]);

                    $quantityRemaining -= $quantityToDeduct;

                    // dd($request->quantity);

                    if ($movement) {
                        // dd($sale->drug);
                        $sale->drug->update([
                            'currentStock' => $sale->drug->currentStock - $request->quantity

                        ]);
                    }
                    Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une sortie du produit ' . $sale->drug->name);
                }

                // If the entry is fully consumed, delete it; otherwise, update the quantity
                if ($availableQuantity == $quantityToDeduct) {
                    $stockEntry->delete();
                } else {
                    $item->currentStock -= $quantityToDeduct;
                    $item->save();
                }
            }

            return redirect()->back()->with('status', 'Sortie effectuée avec succes');
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de faire sortie le produit ' . $item->name . ' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    public function store_mat(Request $request)
    {
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'item_type' => 'required|string',
                'material' => 'nullable|numeric',
                'quantity' => 'numeric|required',
                'sale_date' => 'string|required',
                // 'sale_price' => 'required|numeric',
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

                $item = Drug::where('id', $request->drug)->first();
                // dd($item);

                if ($item->currentStock < $request->quantity) {
                    return redirect()->back()->with('errors', 'Le stock est insuffisant.');
                }


                $availableQuantity = $item->currentStock;
                $quantityToDeduct = min($availableQuantity, $quantityRemaining);

                // Update or create stock movement for the sale
                $movement = StockMovement::create([
                    'type' => 'exit',
                    'item_type' => 'material',
                    'item_id' => $request->drug,
                    'quantity' => $quantityToDeduct,
                    'movement_date' => $request->sale_date,
                    'author' => auth()->user()->id,
                ]);

                $quantityRemaining -= $quantityToDeduct;

                if ($movement) {
                    $sale = Sale::create([
                        'drug_id' => $request->drug,
                        'quantity' => $request->quantity,
                        // 'sale_price' => $request->sale_price,
                        'sale_date' => $request->sale_date
                    ]);
                    // dd($request->quantity);

                    if ($sale) {
                        // dd($sale->drug);
                        $sale->material->update([
                            'currentStock' => $sale->material->currentStock - $request->quantity

                        ]);
                    }
                    Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une sortie du produit ' . $sale->drug->name);
                }

                // If the entry is fully consumed, delete it; otherwise, update the quantity
                if ($availableQuantity == $quantityToDeduct) {
                    $stockEntry->delete();
                } else {
                    $item->currentStock -= $quantityToDeduct;
                    $item->save();
                }
            }

            return redirect()->back()->with('status', 'Sortie effectuée avec succes');
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de faire sortie le produit ' . $item->name . ' sans succès');
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
        // $drugs = DB::table('drugs')->get();
        // dd($drugs);
        // Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifier la vente/sortie n*'. $sale->id);
        return view('sales.edit', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_mat(Sale $sale)
    {
        $drugs = Material::all();
        // Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifier la vente/sortie n*'. $sale->id);
        return view('sales.edit', compact('drugs', 'sale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
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

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $sale->update([
                // 'type' => $request->item_type,
                // 'drug_id' => $request->drug,
                // 'material_id' => $request->material,
                'quantity' => $request->quantity,
                'sale_date' => $request->sale_date,
                'cost' => $request->sale_price
            ]);
            // dd($request->sale_date);

            if ($sale) {
                // $achat = Purchase::findOrFail($purchase->);
                // $element = isset($request->drug) ? $sale->drug->name : $sale->material->name;
                $stockmov =  StockMovement::where('sale_id', $sale->id)->update([
                    'type' => 'exit',
                    'item_type' => $request->item_type,
                    // 'item_id' => $request->item_type == 'product' ? $request->drug : $request->material,
                    'quantity' => $request->quantity,
                    // 'movement_date' => $request->purchase_date,
                    'sale_id' => $sale->id,
                    'author' => auth()->user()->id
                ]);

                // dd($stockmov);
                if ($request->item_type == 'product') {
                    $sale->drug->update([
                        'currentStock' => $sale->drug->currentStock + $request->previous_value - $request->quantity
                    ]);
                } else {
                    $sale->material->update([
                        'currentStock' => $sale->material->currentStock + $request->previous_value - $request->quantity
                    ]);
                }

                return redirect()->back()->with('status', 'Sortie effectuée avec succes');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
            // Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de faire modifier la vente du ' . $sale->drug->name . ' sans succès');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update_mat(Request $request, Sale $sale)
    {
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'item_type' => 'required|string',
                'drug' => 'nullable|numeric',
                'quantity' => 'numeric|required',
                'sale_date' => 'string|required',
                // 'sale_price' => 'required|numeric',
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
                    'item_type' => 'material',
                    'item_id' => $request->drug,
                    'quantity' => $quantityToDeduct,
                    'movement_date' => $request->sale_date,
                    'author' => auth()->user()->id,

                ]);

                $quantityRemaining -= $quantityToDeduct;

                if ($movement) {
                    $sale = Sale::create([
                        'drug_id' => $request->drug,
                        'quantity' => $request->quantity,
                        // 'sale_price' => $request->sale_price,
                        'sale_date' => $request->sale_date
                    ]);
                    // $drug = DB::table('drugs')->where('id', $request->drug)->first();
                    // $currentStock = DB::table('drugs')->where('id', $drug)->update([
                    //     'currentStock' => $drug->currentStock - $request->quantity
                    // ]);
                    Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une sortie du produit ' . $sale->drug->name);
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
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de faire sortie le produit ' . $sale->drug->name . ' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        return redirect()->back()->with('errors', 'Vous n\'avez pas le droit de supprimer cet element');
    }

    public function fiche_stock()
    {
        $users = User::all();
        $drugs = Drug::all();
        // dd($drugs);
        $materials = Material::all();
        $stockMovements = StockMovement::orderBy('movement_date', 'asc')->get();
        Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a visité la fiche de stock');
        return view('stock.fiche', compact('stockMovements', 'materials', 'drugs', 'users'));
    }

    public function fiche_fifo_product($id)
    {
        $users = User::all();
        $drugs = Drug::all();
        $materials = Material::all();
        $sales = Sale::where('drug_id', $id)->get();
        $purchases = Purchase::where('drug_id', $id)->get();
        $stockMovements = StockMovement::where('item_type', 'product')->where('item_id', $id)->orderBy('movement_date', 'asc')->get();
        return view('stock.fiche_fifo', compact('stockMovements', 'sales', 'purchases', 'materials', 'drugs', 'users'));
    }

    public function fiche_fifo_materiel()
    {
        return view('stock.fiche_fifo');
    }
}
