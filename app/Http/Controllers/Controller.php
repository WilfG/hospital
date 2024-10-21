<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function checkPermission($id, $permission_required)
    {
        $permissions = DB::table('permissions')
            ->join('permission_role', 'permissions.id', 'permission_role.permission_id')
            ->join('users', 'permission_role.role_id', 'users.role_id')
            ->where('users.id', $id)->get(['permissions.label_permission'])->toArray();

        // dd($permissions);
        foreach ($permissions as $perm) {
            if ($perm->label_permission == $permission_required) {
                return true;
                break;
            }
        }
       
        // return false;
    }
}
