<?php

namespace Redberry\Spear\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Redberry\Spear\Request get($uri)
 * @method static \Redberry\Spear\Request post($uri, $body = null)
 * @method static \Redberry\Spear\Request delete($uri, $body = null)
 *
 * @see \Redberry\Spear\Request
 */
class Request extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'redberry.request';
	}
}
