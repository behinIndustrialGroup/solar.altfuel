<?php

namespace SolarPlantRequests\Http\Controllers\PanelManufacturer;

use BehinUserRoles\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GetController
{
    public static function getAll()
    {
        return User::query()
        ->where('role_id', 6)
        ->get();
    }

    public static function getById($id)
    {
        return User::query()
        ->where('role_id', 6)
        ->where('id', $id)
        ->first();
    }
}
