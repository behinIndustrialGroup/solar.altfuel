<?php

namespace SolarPlantRequests\Http\Controllers\Contractor;

use BehinUserRoles\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GetController
{
    public static function getAll()
    {
        return User::query()
        ->where('role_id', 5)
        ->get();
    }
}
