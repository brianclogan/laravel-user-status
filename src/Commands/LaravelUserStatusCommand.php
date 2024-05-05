<?php

namespace BrianLogan\LaravelUserStatus\Commands;

use Illuminate\Console\Command;

class LaravelUserStatusCommand extends Command
{
    public $signature = 'laravel-user-status';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
