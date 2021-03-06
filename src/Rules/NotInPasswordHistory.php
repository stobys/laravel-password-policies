<?php

namespace SylveK\LaravelPasswordPolicies\Rules;

use Illuminate\Contracts\Validation\Rule;

use SylveK\LaravelPasswordPolicies\Models\PasswordHistory;

// use SylveK\LaravelPasswordPolicies\Facades\PasswordHistoryManager;

class NotInPasswordHistory implements Rule
{
    protected $user;
    protected $depth;

    // -- NotInPasswordHistory Rule constructor.
    public function __construct($user)
    {
        $this -> user = $user;
        $this -> depth = config('password-policies.password_history_depth', 5);
    }

    public static function ofUser($user)
    {
        return new static($user);
    }

    // -- when rule passes validation
    public function passes($attribute, $value)
    {
        $passwordHistories = PasswordHistory::fetchHistory($this->depth, $this->user);

        foreach ($passwordHistories as $passwordHistory) {
            if (app('hash')->check($value, $passwordHistory->password)) {
                return false;
            }
        }

        return true;

        // return PasswordHistoryManager::notInHistory($value, $this->user, $this->depth);
    }

    // -- Message for failed validation
    public function message()
    {
        return __('auth.password_history') == 'auth.password_history' ? 'The Password Has Been Already Used' : __('auth.password_history');
    }
}
