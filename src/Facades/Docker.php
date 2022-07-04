<?php

namespace Redberry\Spear\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Redberry\Spear\Docker use($image)
 * @method static \Redberry\Spear\Docker shell($shell);
 * @method static \Redberry\Spear\Docker workDir($workDir = '/app');
 * @method static \Redberry\Spear\Docker mountDir($mountDir, $workDir);
 *
 * @see \Redberry\Spear\Docker
 */
class Docker extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'redberry.docker';
	}
}
