<?php

namespace SylveK\LaravelPasswordPolicies\Observers;

use Illuminate\Support\Arr;

// use Imanghafoori\PasswordHistory\Facades\PasswordHistoryManager;
// use Infinitypaul\LaravelPasswordHistoryValidation\Models\PasswordHistoryRepo;

class PasswordChangeObserver
{
    public function saved($user)
    {
        PasswordHistoryManager::logForUserModel($user);
    }

    // public function updated($user)
    // {
    //     $configPasswordColumn = config('password-history.observe.column');
    //     if ($password = Arr::get($user->getChanges(), $configPasswordColumn)) {
    //         PasswordHistoryRepo::storeCurrentPasswordInHistory($password, $user->id);
    //     }
    // }

    // public function created($user)
    // {
    //     $password = config('password-history.observe.column') ?? 'password';
    //     PasswordHistoryRepo::storeCurrentPasswordInHistory($user->{$password}, $user->id);
    // }
}
