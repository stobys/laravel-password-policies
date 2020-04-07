<?php

namespace SylveK\LaravelPasswordPolicies;

use SylveK\LaravelPasswordPolicies\Models\PasswordHistory;
use SylveK\LaravelPasswordPolicies\Observers\PasswordChangeObserver;

class LaravelPasswordPoliciesManager
{
    public function listenForPasswordChanges()
    {
        collect(config('password-policies.password_history_models')) -> map(function ($model, $details) {
            class_exists($model['class']) ? $model['class']::observe(PasswordChangeObserver::class) : null;
        });
    }

    public function logPasswordChange($user)
    {
        return PasswordHistory::create(
            'user_id'       => $user -> id,
            'password'      => $user -> password,
            'created_by'    => optional(auth()->user())->id,
        );
    }
}
