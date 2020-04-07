<?php

namespace SylveK\LaravelPasswordPolicies\Facades;

use Illuminate\Support\Facades\Facade;
use SylveK\LaravelPasswordPolicies\LaravelPasswordPoliciesManager;

class PasswordPoliciesManager extends Facade
{
    // -- Get the registered name of the component.
    protected static function getFacadeAccessor()
    {
        return LaravelPasswordPoliciesManager::class;
    }
}
