<?php

use Illuminate\Support\Facades\Auth;

function can($can){
    $user = Auth::user();
    $permissions =  $user->getAllPermissions();
    // $permissions to array
    $permissionsArray = [];
    foreach ($permissions as $permission) {
        $permissionsArray[] = $permission->name;
    }
    return in_array($can, $permissionsArray);
}
