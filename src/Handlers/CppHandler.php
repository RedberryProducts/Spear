<?php

namespace Redberry\Spear\Handlers;

use Exception;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class CppHandler extends BaseHandler implements Handler
{
	/**
	 * Selected c++ version.
	 */
	private string $version;

	/**
	 * Available c++ versions list.
	 */
	public static array $versions = [
		'14' => 'giunashvili/cpp',
	];

	/**
	 * @throws Exception
	 */
	public function __construct(string $version)
	{
		parent::__construct();

		if (!isset(self::$versions[$version]))
		{
			throw new Exception('Please, provide correct version.');
		}

		$this->version = self::$versions[$version];
	}

	/**
	 * Prepare docker image, code to execute, input and then run the script.
	 */
	public function __invoke(string $code = '', string $input = ''): Data
	{
		$this->setImage($this->version);
		$this->setCode($code);
		$this->setInput($input);
		$this->setCompiledFile('a.out');
		$this->setCompliler('g++ -x c++');

		return $this->compileAndRun();
	}
}
