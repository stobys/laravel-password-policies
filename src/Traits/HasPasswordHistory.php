<?php

namespace SylveK\LaravelPasswordPolicies\Traits;

use SylveK\LaravelPasswordPolicies\Models\PasswordHistory;

trait PasswordHistoryTrait
{
    // -- Models related passwords
    public function passwordHistory()
    {
        return $this -> hasMany(PasswordHistory::class) -> latest();
    }

    public function deleteOlderPasswordHistory()
    {
        $depth = config('password-policies.password_history_depth', 5);
        $count = $this -> passwordHistory() -> where('user_id', $this->id) -> count();

        $this -> passwordHistory()
                -> where('user_id', $this->id)
                -> addSelect(['id' => PasswordHistory::select('id')
                    -> where('user_id', $this -> id)
                    -> oldest()
                    -> take($count - $depth)
                ]) -> get();
    }

    public function clearPasswordHistory()
    {
        $this -> passwordHistory()
                -> where('user_id', $this->id)
                -> delete();
    }
}
