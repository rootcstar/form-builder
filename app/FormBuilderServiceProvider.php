<?php

namespace RootCStar\FormBuilder;

use Illuminate\Support\ServiceProvider;

class FormBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'form-builder');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/form-builder'),
        ], 'form-builder-views');

        $this->publishes([
            __DIR__.'/../resources/js' => public_path('vendor/form-builder/js'),
        ], 'form-builder-scripts');
    }

    public function register()
    {
        //
    }
}
