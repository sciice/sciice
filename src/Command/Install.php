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

        $this->registerSciiceServiceProvider();

        $this->info('Sciice installed successfully.');
    }

    /**
     * @return void
     */
    protected function registerSciiceServiceProvider()
    {
        file_put_contents(config_path('app.php'), str_replace(
            "App\Providers\EventServiceProvider::class,".PHP_EOL,
            "App\Providers\EventServiceProvider::class,".PHP_EOL."        Sciice\Provider\SciiceServiceProvider::class,".PHP_EOL,
            file_get_contents(config_path('app.php'))
        ));
    }
}
