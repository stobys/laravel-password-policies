<?php

return [
    // -- User model
    'user_model'    => App\Models\User::class,

    // -- The table name to store password histories in
    'password_history_table' => 'password_histories',

    // -- How many previous passwords have to be stored for check against
    'password_history_depth' => env('PASSWORD_HISTORY_DEPTH', 3),

    // -- Models observed for password change
    'password_history_models' => [
        [
            \App\Models\User::class = [
                'field'	=> 'password',
            ]
        ],
    ],
];
