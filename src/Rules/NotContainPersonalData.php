<?php

namespace SylveK\LaravelPasswordPolicies\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

// use SylveK\LaravelPasswordPolicies\Facades\PasswordHistoryManager;

class NotContainPersonalData implements Rule
{
    protected $user;

    // -- NotInPasswordHistory Rule constructor.
    public function __construct($user)
    {
        $this -> user = $user;
    }

    public static function ofUser($user)
    {
        return new static($user);
    }

    // -- when rule passes validation
    public function passes($attribute, $value)
    {
        $personalData = [
            'username'		=> strtolower($this -> user -> username),
            'family_name'	=> strtolower($this -> user -> family_name),
            'given_name'	=> strtolower($this -> user -> given_name),
            'email'			=> strtolower($this -> user -> email),
        ];

        foreach ($personalData as $data) {
            if (Str::contains($value, $data)) {
                return false;
            }
        }

        return true;
        // return PasswordPolicyManager::notContainPersonalData($value, $this->user);
    }

    // -- Message for failed validation
    public function message()
    {
        return __('auth.personal_data') == 'auth.personal_data' ? 'The Password Cannot Contain Any Of Users Personal Data' : __('auth.personal_data');
    }
}
