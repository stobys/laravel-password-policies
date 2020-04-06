<?php

namespace SylveK\LaravelPasswordPolicies\Commands;

use Illuminate\Console\Command;

class ClearPasswordHistory extends Command
{
    protected $signature = 'password-policies:clear-password-history';

    protected $description = 'Clear users whole password history';

    public function handle()
    {
        $this->error('@TODO');
    }
}
