<?php

namespace Redberry\Spear;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Redberry\Spear\Commands\FetchDockerImage;

class ServiceProvider extends LaravelServiceProvider
{
	public function boot()
	{
		$this->app->singleton('redberry.spear', Spear::class);

		if ($this->app->runningInConsole())
		{
			$this->commands([
				FetchDockerImage::class,
			]);
		}
	}
}
