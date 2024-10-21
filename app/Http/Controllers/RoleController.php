<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkPermission = $this->checkPermission(auth()->user()->id, 'Voir la liste des rôles');
        if ($checkPermission == false) {
            return redirect()->back()->with('errors', "Vous n'avez pas la permission de Voir la liste des rôles.");
        }

        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $checkPermission = $this->checkPermission(auth()->user()->id, 'Créer un rôle');
        if ($checkPermission == false) {
            return redirect()->back()->with('errors', "Vous n'avez pas la permission de Créer un rôle.");
        }

        try {
            $validator =  Validator::make($request->all(), [
                'label' => ['required', 'string', 'max:255', 'unique:roles,string'],
                'permissions' => ['required']
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $role = Role::create([
                'role_label' => $request->label
            ]);
            $role->permissions()->attach($request->permissions);

            if ($role) {
                Log::channel('gestion_utilisateur')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a créé un rôle (profil utilisateur)');
                return redirect()->route('roles.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_utilisateur')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de créer un rôle (profil utilisateur) sans succès');
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
        $permissions = Permission::all();
        $role = Role::where('id', $id)->with('permissions')->first();
        return view('roles.edit', ['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Modifier un rôle');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Modifier un rôle.");
            }

            $validator =  Validator::make($request->all(), [
                'label' => ['nullable', 'string', 'max:255'],
                'permissions' => ['required']
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $role->update([
                'role_label' => $request->label
            ]);
            $role->permissions()->sync($request->permissions);
            if ($role) {
                Log::channel('gestion_utilisateur')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifié un rôle(profil utilisateur)');
                return redirect()->route('roles.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_utilisateur')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de modifier les informations d\'un rôle(profil utilisateur) sans succès');
            return redirect()->back()->with(['errors' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {

            $checkPermission = $this->checkPermission(auth()->user()->id, 'Supprimer un rôle');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Supprimer un rôle.");
            }

            if ($role) {
                Log::channel('gestion_utilisateur')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a supprimé le rôle ' . $role->role_label);
                $role->delete();
                return redirect()->back()->with('success', 'Rôle supprimé avec succes.');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_utilisateur')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer le rôle(profil utilisateur)' . $role->role_label . ' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }
}
