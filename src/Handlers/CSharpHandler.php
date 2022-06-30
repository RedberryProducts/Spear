<?php

namespace Redberry\Spear\Handlers;

use Exception;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class CSharpHandler extends BaseHandler implements Handler
{
	/**
	 * Available C# versions list.
	 */
	public static array $versions = [
		'6'    => 'mono:6',
		'6.10' => 'mono:6.10',
		'6.12' => 'mono:6.12',
	];

	/**
	 * Selected C# version.
	 */
	private string $version;

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
		$this->setCompiledFile('program.exe');
		$this->setCompliler('mcs');
		$this->setExecutor('mono');

		return $this->compileAndRun();
	}
}
