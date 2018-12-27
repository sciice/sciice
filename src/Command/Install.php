<?php

namespace Sciice\Command;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * @var string
     */
    protected $signature = 'sciice:install';

    /**
     * @var string
     */
    protected $description = 'Install all of the Sciice resources.';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->comment('Publishing Sciice Resources...');

        $this->callSilent('vendor:publish', [
            '--tag'   => 'sciice-config',
            '--force' => true,
        ]);

        $this->info('Sciice installed successfully.');
    }
}
