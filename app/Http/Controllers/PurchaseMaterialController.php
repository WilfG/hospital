<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Magasin;
use App\Models\Material;
use App\Models\Purchase;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PurchaseMaterialController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('material')
            ->where('type', 'material')
            ->get();
        // dd($purchases);
        Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a visité la liste des approvisionnements');
        return view('achats_mat.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $drugs = Drug::all();
        $materiels = Material::all();
        return view('achats_mat.create', compact('materiels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try { 
            $validator = Validator::make($request->all(), [
                'usage_type' => 'required|string',
                'drug' => 'nullable|numeric',
                'material' => 'nullable|numeric',
                'quantity' => 'numeric|required',
                'purchase_date' => 'string|required',
                'cost' => 'required|numeric',
            ]);
            
            // dd($request);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $item = Material::where('id', $request->material)->first();

            if ($request->usage_type == 'mag') { //Sortie Magasin
                $magasin = Magasin::create([
                    'material_id' => $request->material,
                    'movement_type' => 'entry',
                    'quantity' => $request->quantity,
                    'cost' => $request->cost,
                    'user_id' => auth()->user()->id,
                ]);
                if ($magasin) {
                    # code...
                    $item->update([
                        'stockMag' => $item->stockMag + $request->quantity,
                        // 'currentStock' => $item->currentStock + $request->quantity
                    ]);
                   
                    Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une sortie du matériel ' . $item->name . 'du magasin');
                    return redirect()->back()->with('status', 'Approvisonnement effectué avec succes');
                }
            } else {
                
                // Assuming request has 'type', 'product_id', 'material_id', 'quantity', 'cost', 'purchase_date'
                $purchase = Purchase::create([
                    'type' => 'material',
                    // 'drug_id' => $request->drug,
                    'material_id' => $request->material,
                    'quantity' => $request->quantity,
                    'purchase_date' => $request->purchase_date,
                    'cost' => $request->cost
                ]);
                
                if ($purchase) {
                    $element = $purchase->material->name;
                    StockMovement::create([
                        'type' => 'entry',
                        'item_type' => 'material',
                        'item_id' => $request->material,
                        'quantity' => $request->quantity,
                        'movement_date' => $request->purchase_date,
                        'cost' => $request->cost,
                        'author' => auth()->user()->id,
                        'purchase_id' => $purchase->id
                    ]);
                        // dd($purchase->material->id);

                    $purchase->material->update([
                        // 'currentStock' => $purchase->material->currentStock + $request->quantity,
                        'stockMag' => $purchase->material->currentStock + $request->quantity
                    ]);

                    Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une sortie de ' . $element);
                    return redirect()->back()->with('status', 'Approvisonnement enregistré avec succes');
                }
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de faire  entrer un produit ou materiel sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        // dd($purchase->drug_id);
        $drugs = Drug::all();
        $materiels = Material::all();
        return view('achats.edit', compact('materiels', 'drugs', 'purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {

        try {
            $validator = Validator::make($request->all(), [
                'item_type' => 'required|string',
                'drug' => 'nullable|numeric',
                'material' => 'nullable|numeric',
                'quantity' => 'numeric|required',
                'purchase_date' => 'string|required',
                'cost' => 'required|numeric',
                'previous_value' => 'required|numeric'
            ]);


            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            dd($request->purchase_date);
            $purchase->update([
                'type' => $request->item_type,
                'drug_id' => $request->drug,
                'material_id' => $request->material,
                'quantity' => $request->quantity,
                'purchase_date' => $request->purchase_date,
                'cost' => $request->cost
            ]);

            if ($purchase) {
                // $achat = Purchase::findOrFail($purchase->);
                $element = isset($request->drug) ? $purchase->drug->name : $purchase->material->name;
                $stockmov =  StockMovement::where('purchase_id', $purchase->id)->update([
                    'type' => 'entry',
                    'item_type' => $request->item_type,
                    'item_id' => $request->item_type == 'product' ? $request->drug : $request->material,
                    'quantity' => $request->quantity,
                    'movement_date' => $request->purchase_date,
                    // 'cost' => $request->cost,
                    'author' => auth()->user()->id
                ]);

                // dd($stockmov);
                if ($request->item_type == 'product') {
                    $purchase->drug->update([
                        'currentStock' => $purchase->drug->currentStock - $request->previous_value + $request->quantity
                    ]);
                } else {
                    $purchase->material->update([
                        'currentStock' => $purchase->material->currentStock - $request->previous_value + $request->quantity
                    ]);
                }

                Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué la modification d\'une sortie de ' . $element);
                return redirect()->back()->with('status', 'Achat modifié avec succes');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_stock_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de faire  entrer un produit ou materiel sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
