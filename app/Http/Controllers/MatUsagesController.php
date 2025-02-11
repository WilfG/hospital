<?php

namespace App\Http\Controllers;

use App\Imports\DrugsImport;
use App\Models\Drug;
use App\Models\Magasin;
use App\Models\Material;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MatUsagesController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usages = StockMovement::where('item_type', 'material')->get();
        $materials = Material::all();
        Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a visité la liste des sorties de matériels');
        return view('usages.index', compact('usages', 'materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materials = Material::all();
        return view('usages.create', compact('materials'));
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
                'material' => 'nullable|numeric',
                'quantity' => 'numeric|required',
                'sale_date' => 'string|required',
                // 'sale_price' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }


            // Implement FIFO logic for stock movement
            $quantityRemaining = $request->quantity;
            // dd($quantityRemaining);

            while ($quantityRemaining > 0) {
                $stockEntry = StockMovement::where('item_type', 'material')
                    ->where('item_id', $request->material)
                    ->where('type', 'entry')
                    ->orderBy('movement_date', 'asc')
                    ->first();

                $item = Material::where('id', $request->material)->first();
                // dd($item);
                if ($request->item_type == 'stock' && $item->currentStock < $request->quantity) {
                 return redirect()->back()->with('errors', 'Le stock est insuffisant.');
                }


                // $availableQuantity = $item->currentStock;
                // $quantityToDeduct = min($availableQuantity, $quantityRemaining);

                if ($request->usage_type == 'mag') { //Sortie Magasin
                    $magasin = Magasin::create([
                        'material_id' => $request->material,
                        'movement_type' => 'exit',
                        'quantity' => $request->quantity
                    ]);
                    if ($magasin) {
                        # code...
                        $item->update([
                            'stockMag' => $item->stockMag - $request->quantity,
                            'currentStock' => $item->currentStock + $request->quantity
                        ]);
                        Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une sortie du matériel ' . $item->name . 'du magasin');
                        return redirect()->back()->with('status', 'Sortie effectuée avec succes');
                    }
                } else { //Stock hopital
                    // Update or create stock movement for the sale
                    $movement = StockMovement::create([
                        'type' => 'exit',
                        'item_type' => 'material',
                        'item_id' => $request->material,
                        'quantity' => $$request->quantity,
                        'movement_date' => $request->sale_date,
                        'author' => auth()->user()->id,
                    ]);

                    if ($movement) {

                        $item->update([
                            'currentStock' => $item->currentStock - $request->quantity

                        ]);

                        // }
                        Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une sortie du matériel ' . $item->name);
                        return redirect()->back()->with('status', 'Sortie effectuée avec succes');
                    }
                }
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de faire sortie le matériel ' . $item->name . ' sans succès');
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
        $drugs = Drug::all();
        // Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifier la vente/sortie n*'. $sale->id);
        return view('usages.edit', compact('drugs', 'sale'));
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
                    'author' => auth()->user()->id,

                ]);

                $quantityRemaining -= $quantityToDeduct;

                if ($movement) {
                    $sale = Sale::create([
                        'drug_id' => $request->drug,
                        'quantity' => $request->quantity,
                        'sale_price' => $request->sale_price,
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

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx'

        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors());
        }

        $file = $request->file('file');

        dd($file);
        Excel::import(new DrugsImport, $file);


        return redirect()->back()->with('success', 'Users imported successfully.');
    }

    public function importview()
    {
        return view('usages.upload');
    }
}
