<?php

namespace Redberry\Spear\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Redberry\Spear\Docker use($image)
 * @method static \Redberry\Spear\Docker shell($shell = '');
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
