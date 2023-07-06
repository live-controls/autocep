<?php

namespace LiveControls;

use LiveControls\Http\Livewire\AutoCEP\AutoCep;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LiveControlsServiceProvider extends ServiceProvider
{
  public function register()
  {
  }

  public function boot()
  {
    $this->loadTranslationsFrom(__DIR__.'/../lang', 'livecontrols');
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'livecontrols');

    Livewire::component('livecontrols-autocep', AutoCep::class);
  
    $this->publishes([
      __DIR__.'/../lang' => $this->app->langPath('vendor/livecontrols'),
    ], 'livecontrols-localization');
  }
}
