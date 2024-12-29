<?php

namespace RootCStar\FormBuilder;

use Illuminate\Support\ServiceProvider;

class FormBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'form-builder');

        // This allows users to publish your views to their own views directory
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/form-builder'),
        ], 'form-builder-views');
    }

    public function register()
    {
        //
    }
}
