<?php

namespace Sciice\Provider;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('resource', function ($action) {
            return "<?php foreach(Sciice::{$action}() as \$name => \$path): ;?>" . $this->if($action) . $this->else($action) . $this->endIf() . "<?php endforeach; ?>";
        });
    }

    public function register()
    {
        //
    }

    private function if($action)
    {
        if ($action === 'style') {
            return "<?php if(starts_with(\$path, ['http://', 'https://'])): ?><link rel=\"stylesheet\" href=\"<?php echo \$path; ?>\">\n";
        } else {
            return "<?php if(starts_with(\$path, ['http://', 'https://'])): ?><script src=\"<?php echo \$path; ?>\"></script>\n";
        }
    }

    private function else($action)
    {
        $path = config('sciice.path');
        if ($action == 'style') {
            return "<?php else: ?><link rel=\"stylesheet\" href=\"<?php echo e(url('/{$path}/{$action}', ['name' => \$name]))?>\">\n";
        } else {
            return "<?php else: ?><script src=\"<?php echo e(url('/{$path}/{$action}', ['name' => \$name]))?>\"></script>\n";
        }
    }

    private function endIf()
    {
        return "<?php endif; ?>";
    }
}
