<?php

namespace SylveK\LaravelPasswordPolicies\Commands;

use Illuminate\Console\Command;
use SylveK\LaravelPasswordPolicies\Models\PasswordHistory;
use App\Models\User;

class ClearPasswordHistory extends Command
{
    // -- The name and signature of the console command.
    protected $signature = 'password-history:clear
                                {--user= : optional, user (id or username) do delete history}';

    protected $description = 'Clears password history';

    public function handle()
    {
        $user = $this -> option('user');

        switch (true) {
            case is_null($user):
                PasswordHistory::truncate();
            break;

            case is_numeric($user):
                PasswordHistory::where('user_id', $user) -> delete();
            break;

            case is_string($user):
                // -- Way #1
                PasswordHistory::whereUserId(function ($query) use ($user) {
                    $query -> select('id') -> from('users') -> where('username', $user);
                }) -> delete();

                // -- Way #2
                // $user = User::where('username', $user)->first();
                // if ($user) {
                //     PasswordHistory::where('user_id', $user->id) -> delete();
                // }

                // -- Which Way is better?
            break;
        }

        $this->comment('    >> Password History cleared!');
    }
}
