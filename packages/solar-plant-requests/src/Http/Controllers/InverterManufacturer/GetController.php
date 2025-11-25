<?php

namespace SolarPlantRequests\Http\Controllers\InverterManufacturer;

use BehinUserRoles\Models\User;

class GetController
{
    public static function getAll()
    {
        return User::query()
            ->where('role_id', 7)
            ->get();
    }

    public static function getById($id)
    {
        return User::query()
            ->where('role_id', 7)
            ->where('id', $id)
            ->first();
    }
}

