<?php

namespace SylveK\LaravelPasswordPolicies;

use SylveK\LaravelPasswordPolicies\Models\PasswordHistory;
use SylveK\LaravelPasswordPolicies\Observers\PasswordChangeObserver;

class LaravelPasswordPoliciesManager
{
    public static function listenForPasswordChanges()
    {
        $models = config('password-policies.password_history_models');

        // foreach ($models as $modelClass => $modelDetails) {
        //     $modelClass::observe(UserObserver::class);
        // }

        collect(config('password-policies.password_history_models')) -> map(function ($model, $test) {
            dd($model, $test);
            class_exists($model['class']) ? $model['class']::observe(PasswordChangeObserver::class) : null;
        });

        // $userModels = array_keys(config('password_history.models'));

        // foreach ($userModels as $userModel) {
        //     $userModel::observe(UserObserver::class);
        // }
    }

    public function logForUserModel($user)
    {
        $passwordCol = $this->getPasswordCol($user);

        if ($user->$passwordCol && $user->isDirty($passwordCol)) {
            $guard = $this->getGuard($user);
            PasswordHistoryRepo::logNewPassword($user->$passwordCol, $user->getKey(), $guard);
        }
    }

    private function getPasswordCol($user)
    {
        $models = config('password-policies.password_history_models');

        return $models[get_class($user)]['field'] ?? 'password';
    }

    public function logPasswordForUser($passwordHash, $user)
    {
        return PasswordHistoryRepo::logNewPassword($passwordHash, $user->getKey(), $this->getGuard($user));
    }

    public static function logNewPassword($password, $user_id, $guard = '')
    {
        return PasswordHistory::query()->create(get_defined_vars());
    }
}