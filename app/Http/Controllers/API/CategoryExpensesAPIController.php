<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expenses_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryExpensesAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Expenses_category::orderBy('id', 'desc')->get();
        $options = '';
        $options .= '<select name="label_categorie" class="selectpicker " data-live-search="true" required>';
        foreach ($categories as  $cat) {
            $options .= '<option value="' . $cat->id . '">' . $cat->label . '</option>';
        }
        $options .= '</select>';
        $options .= '<span class=""><a href="#" title="Ajouter une nouvelle catégorie" class="btn btn-success btn-small" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></a></span>';
        return response()->json($options);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            // $checkPermission = $this->checkPermission(auth()->user()->id, 'Créer une catégorie de dépense');
            // if ($checkPermission == false) {
            //     return response()->json(['errors', "Vous n'avez pas la permission de Créer une catégorie de dépense."]);
            // }
            // return response()->json($request);

            $validator = Validator::make($request->only(['label_categorie']), [
                'label_categorie' => ['required', 'min:2', 'max:50', 'string', 'unique:expenses_categories,label']
            ]);

            if ($validator->fails()) {
                return response()->json(['err' => $validator->errors()]);
            }

            $expenses_category = DB::table('expenses_categories')->insert([
                'label' => $request->label_categorie
            ]);
            if ($expenses_category) {
                // Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a créé une catégorie de dépenses');
                $categories = Expenses_category::orderBy('id', 'desc')->get();

                $options = '';
                $options .= '<select name="label_categorie" class="selectpicker " data-live-search="true" required>';
                foreach ($categories as  $cat) {
                    $options .= '<option value="' . $cat->id . '">' . $cat->label . '</option>';
                }
                $options .= '</select>';
                $options .= '<span class=""><a href="#" title="Ajouter une nouvelle catégorie" class="btn btn-success btn-small" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></a></span>';
                return response()->json($options);
            }
        } catch (\Throwable $th) {
            // Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de créer une catégorie de dépenses sans succès');
            return response()->json(['err' => $th->getMessage()]);
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
}
