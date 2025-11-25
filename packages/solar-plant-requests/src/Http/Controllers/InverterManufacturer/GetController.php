<?php

namespace SolarPlantRequests\Http\Controllers\InverterManufacturer;

use BehinUserRoles\Models\User;

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

