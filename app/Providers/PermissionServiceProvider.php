<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class PermissionServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        // ...
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        Blade::directive('perm', function ($perm) {
            return "<?php if(auth()->check() && auth()->user()->hasPermAnyWay({$perm})): ?>";
        });
        Blade::directive('endperm', function ($perm) {
            return "<?php endif; ?>";
        });
        Blade::directive('allperms', function ($perms) {
            return "<?php if(auth()->check() && auth()->user()->hasAllPerms({$perms})): ?>";
        });
        Blade::directive('endallperms', function ($perms) {
            return "<?php endif; ?>";
        });
        Blade::directive('anyperms', function ($perms) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyPerms({$perms})): ?>";
        });
        Blade::directive('endanyperms', function ($perms) {
            return "<?php endif; ?>";
        });
    }
}
