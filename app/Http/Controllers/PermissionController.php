<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkPermission = $this->checkPermission(auth()->user()->id, 'Voir la liste des permissions');
        if ($checkPermission == false) {
            return redirect()->back()->with('errors', "Vous n'avez pas la permission de Voir la liste des permissions.");
        }

        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $checkPermission = $this->checkPermission(auth()->user()->id, 'Créer une permission');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Créer une permission.");
            }

            $validator =  Validator::make($request->all(), [
                'label' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $permission = Permission::create([
                'label_permission' => $request->label
            ]);
            if ($permission) {
                return redirect()->route('permissions.index');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with(['errors' => $th->getMessage()]);
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
    public function edit(string $id)
    {
        $permission = Permission::findorFail($id);
        return view('permissions.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $checkPermission = $this->checkPermission(auth()->user()->id, 'Modifier une permission');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Modifier une permission.");
            }

            $validator =  Validator::make($request->all(), [
                'label' => ['nullable', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $role = DB::table('permissions')->where('id', $id)->update([
                'label_permission' => $request->label
            ]);
            if ($role) {
                return redirect()->route('permissions.index');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with(['errors' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {

            $checkPermission = $this->checkPermission(auth()->user()->id, 'Supprimer une permission');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Supprimer une permission.");
            }

            if ($permission) {
                $permission->delete();
                return redirect()->back()->with('success', 'Permission supprimée avec succes.');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }
}
