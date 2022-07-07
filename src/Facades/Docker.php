<?php

namespace Redberry\Spear\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Redberry\Spear\Docker use($image)
 * @method static \Redberry\Spear\Docker shell($shell);
 * @method static \Redberry\Spear\Docker workDir($workDir = '/app');
 * @method static \Redberry\Spear\Docker mountDir($mountDir, $workDir);
 * @method static \Redberry\Spear\Docker imageExistsLocally($image)
 * @method static \Redberry\Spear\Docker isDockerInstalled()
 * @method static \Redberry\Spear\Docker pruneImage($image)
 * @method static \Redberry\Spear\Docker pruneImageForcibly($image)
 * @method static \Redberry\Spear\Docker pull($image)
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
