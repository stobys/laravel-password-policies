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

    public function logPasswordChange($model)
    {
        if (array_has('password', $model->getChanges())) {
            return PasswordHistory::create([
                'user_id'       => $model -> id,
                'password'      => $model -> password,
                'created_by'    => optional(auth()->user())->id,
            ]);
        }
    }
}
