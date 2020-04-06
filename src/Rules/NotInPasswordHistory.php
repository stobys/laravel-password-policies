<?php

namespace SylveK\PasswordPolicies\Rules;

use Illuminate\Contracts\Validation\Rule;

use SylveK\PaswordPolicies\Models\PasswordHistory;

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

    // -- when rule passes validation
    public function passes($attribute, $value)
    {
        $passwordHistories = PasswordHistory::fetchHistory($this->user, $this->checkPrevious);
		
        foreach ($passwordHistories as $passwordHistory) {
            if ( app('hash')->check($value, $passwordHistory->password) ) {
                return false;
            }
        }

        return true;
    }

    // -- Message for failed validation
    public function message()
    {
        return __('auth.password_history') == 'auth.password_history' ? 'The Password Has Been Already Used' : __('auth.password_history');
    }
}