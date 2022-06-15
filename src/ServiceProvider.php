<?php

namespace Redberry\Spear;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Redberry\Spear\Commands\FetchImages;

class ServiceProvider extends LaravelServiceProvider
{
	public function boot()
	{
		$this->app->singleton('redberry.spear', Spear::class);

		if ($this->app->runningInConsole())
		{
			$this->commands([
				FetchImages::class,
			]);
		}
	}
}
