<?php

namespace RootCStar\FormBuilder;

use Illuminate\Support\ServiceProvider;

class FormBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'form-builder');

        /*$this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/form-builder'),
        ], 'form-builder-views');

        $this->publishes([
            __DIR__.'/../public/js' => public_path('vendor/form-builder/js'),
        ], 'form-builder-scripts');

        $this->publishes([
            __DIR__.'/../config/form-builder.php' => config_path('form-builder.php'),
        ], 'form-builder-config');*/

        // Publishing everything to a single directory in public
        $this->publishes([
            __DIR__.'/../resources/views' => public_path('vendor/form-builder/views'),
            __DIR__.'/../public/js' => public_path('vendor/form-builder/js'),
            __DIR__.'/../config/form-builder.php' => public_path('vendor/form-builder/config/form-builder.php'),
        ], 'form-builder-assets');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/form-builder.php', 'form-builder'
        );
    }
}
