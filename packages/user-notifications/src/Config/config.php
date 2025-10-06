<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User Notifications Configuration
    |--------------------------------------------------------------------------
    |
    | You may customize the behaviour of the notification package by publishing
    | this configuration file. The default user model is resolved from the
    | authentication provider and the default middleware protects the routes.
    |
    */
    'user_model' => env('USER_NOTIFICATIONS_USER_MODEL'),

    'admin_middleware' => ['web', 'auth', 'can:manage-user-notifications'],

    'user_middleware' => ['web', 'auth'],
];
