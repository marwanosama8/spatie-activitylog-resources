<?php

namespace Marwanosama8\SpatieActivitylogResources\Commands;

use Illuminate\Console\Command;

class SpatieActivitylogResourcesCommand extends Command
{
    public $signature = 'spatie-activitylog-resources';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All doness');

        return self::SUCCESS;
    }
}
