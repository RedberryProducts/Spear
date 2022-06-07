<?php

namespace Redberry\Spear\Handlers;

use Exception;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class RustHandler extends BaseHandler implements Handler
{
	/**
	 * Selected rust version.
	 */
	private string $version;

	/**
	 * Available rust versions list.
	 */
	private array $versions = [
		'1' => 'rust:1',
	];

	/**
	 * @throws Exception
	 */
	public function __construct(string $version)
	{
		parent::__construct();

		if (!isset($this->versions[$version]))
		{
			throw new Exception('Please, provide correct version.');
		}

		$this->version = $this->versions[$version];
	}

	/**
	 * Prepare docker image, code to execute, input and then run the script.
	 */
	public function __invoke(string $code, string $input = ''): Data
	{
		$this->setImage($this->version);
		$this->setCode($code);
		$this->setInput($input);
		$this->setCompliler('rustc');
		$this->setCompiledFile('program');

		return $this->compileAndRun();
	}
}
