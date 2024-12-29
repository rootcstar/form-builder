<?php

namespace RootCStar\FormBuilder;

use Illuminate\Support\ServiceProvider;

class FormBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Update the path to point to the correct location
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'form-builder');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/form-builder'),
        ], 'form-builder-views');
    }

    public function register()
    {
        //
    }
}
