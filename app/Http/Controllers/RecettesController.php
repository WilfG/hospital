<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class RecettesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recettes = Recette::all();
        return view('recettes.index', compact('recettes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recettes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'cost' => 'required|numeric',
                'label' => 'rquired|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }


            $recette = Recette::create([
                'label' => $request->label,
                'cost' => $request->cost,
                'user_id' => auth()->user()->id
            ]);

            if ($recette) {
                return redirect()->route('recettes.index');
            }
        } catch (Throwable $th) {

            return redirect()->back()->with('errors', $th->getMessage());
        }
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
    public function edit(Recette $recette)
    {
        return view('recettes.edit', compact('recette'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'cost' => 'required|numeric',
                'label' => 'rquired|string',
            ]);

            // dd($request);
            // if ($validator->fails()) {
            //     return redirect()->back()->with('errors', $validator->errors());
            // }

            $recette = Recette::findOrFail($id)->update([
                'label' => $request->label,
                'cost' => $request->cost,
                'user_id' => auth()->user()->id
            ]);

            if ($recette) {
                return redirect()->route('recettes.index');
            }
        } catch (Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
