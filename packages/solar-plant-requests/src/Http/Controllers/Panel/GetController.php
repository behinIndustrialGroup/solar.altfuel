<?php

namespace SolarPlantRequests\Http\Controllers\Panel;

use BehinUserRoles\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use SolarPlantRequests\Models\Panel;

class GetController
{
    public static function getAll()
    {
        return User::query()
            ->where('role_id', 5)
            ->get();
    }

    public static function getById($id)
    {
        return User::query()
            ->where('role_id', 5)
            ->where('id', $id)
            ->first();
    }

    /**
     * Get all panels registered by the current user
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUserPanels()
    {
        return Panel::query()
            ->with('request')
            ->where('manufacturer_user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
