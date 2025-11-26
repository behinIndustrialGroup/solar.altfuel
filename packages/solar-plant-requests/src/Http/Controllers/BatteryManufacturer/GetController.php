<?php

namespace SolarPlantRequests\Http\Controllers\BatteryManufacturer;

use BehinUserRoles\Models\User;

class GetController
{
    public static function getAll()
    {
        return User::query()
            ->where('role_id', 8)
            ->get();
    }

    public static function getById($id)
    {
        return User::query()
            ->where('role_id', 8)
            ->where('id', $id)
            ->first();
    }
}
