<?php

namespace Redberry\Spear;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
	public function boot()
	{
		$this->app->singleton('redberry.spear', Spear::class);
	}
}
