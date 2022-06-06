<?php

namespace Redberry\Spear\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Redberry\Spear\Spear node(string $version = '14')
 * @method static \Redberry\Spear\Spear php()
 * @method static \Redberry\Spear\Spear cpp()
 * @method static \Redberry\Spear\Spear python()
 * @method static \Redberry\Spear\Spear ruby()
 * @method static \Redberry\Spear\Spear rust()
 * @method static \Redberry\Spear\Spear cSharp()
 * @method static \Redberry\Spear\Spear go()
 * @method static \Redberry\Spear\Spear java()
 * @method static \Redberry\Spear\Spear perl()
 *
 * @see \Redberry\Spear\Spear
 */
class Spear extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'redberry.spear';
	}
}
