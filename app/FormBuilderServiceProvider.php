<?php

namespace RootCStar\FormBuilder;

use Illuminate\Support\ServiceProvider;

class FormBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load views from your package
        $this->loadViewsFrom(__DIR__.'/resources/views', 'form-builder');

        // Allow users to publish views if they want to customize them
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/form-builder'),
        ], 'form-builder-views');
    }

    public function register()
    {
        //
    }
}
