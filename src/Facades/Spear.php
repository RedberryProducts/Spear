<?php

namespace Redberry\Spear\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Redberry\Spear\Spear node(string $version = '14')
 * @method static \Redberry\Spear\Spear php(string $version = '8')
 * @method static \Redberry\Spear\Spear cpp(string $version = '14')
 * @method static \Redberry\Spear\Spear python(string $version = '3.10')
 * @method static \Redberry\Spear\Spear ruby(string $version = '3')
 * @method static \Redberry\Spear\Spear rust(string $version = '1')
 * @method static \Redberry\Spear\Spear cSharp(string $version = '6.12')
 * @method static \Redberry\Spear\Spear go(string $version = '1.18')
 * @method static \Redberry\Spear\Spear java(string $version = '11')
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
