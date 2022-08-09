<?php

namespace Redberry\Spear;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Redberry\Spear\Commands\DockerImagesList;
use Redberry\Spear\Commands\FetchDockerImage;

class ServiceProvider extends LaravelServiceProvider
{
	public function boot()
	{
		$this->app->singleton('redberry.spear', Spear::class);
		$this->app->singleton('redberry.docker', Docker::class);
		$this->app->singleton('redberry.request', Request::class);

		if ($this->app->runningInConsole())
		{
			$this->commands([
				FetchDockerImage::class,
				DockerImagesList::class,
			]);
		}

		if ($this->app->runningInConsole())
		{
			$this->registerPublishing();
		}
	}

	protected function registerPublishing()
	{
		$this->publishes([
			__DIR__ . '/../config/spear.php' => config_path('spear.php'),
		], 'spear-config');
	}
}
