<?php

namespace SylveK\LaravelPasswordPolicies\Commands;

use Illuminate\Console\Command;
use SylveK\LaravelPasswordPolicies\Models\PasswordHistory;
use App\Models\User;

class ClearPasswordHistory extends Command
{
    // -- The name and signature of the console command.
    protected $signature = 'password-history:clear
                                {--user= : user do delete history}';

    protected $description = 'Clears password history';

    public function handle()
    {
        $user = $this -> option('user');

        switch (true) {
            case is_null($user):
                PasswordHistory::truncate();
            break;

            case is_int($user):
                PasswordHistory::where('user_id', $user) -> delete();
            break;

            case is_string($user):
                $user = User::where('username', $user)->firstOrFail();
                PasswordHistory::where('user_id', $user->id) -> delete();
            break;
        }

        $this->comment('    >> Password History cleared!');
    }
}
