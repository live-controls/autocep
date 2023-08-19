<?php

namespace LiveControls\AutoCep;

use LiveControls\AutoCep\Http\Livewire\AutoCep;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AutoCepServiceProvider extends ServiceProvider
{
  public function register()
  {
  }

  public function boot()
  {
    $this->loadTranslationsFrom(__DIR__.'/../lang', 'livecontrols-autocep');
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'livecontrols-autocep');

    Livewire::component('livecontrols-autocep', AutoCep::class);
  
    $this->publishes([
      __DIR__.'/../lang' => $this->app->langPath('vendor/livecontrols-autocep'),
    ], 'livecontrols.autocep.localization');

    $this->publishes([
      __DIR__.'/../resources/views' => $this->app->resourcePath('views/vendor/livecontrols-autocep')
    ], 'livecontrols.autocep.views');
  }
}
