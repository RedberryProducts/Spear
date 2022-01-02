<?php

namespace Giunashvili\Spear;

use Giunashvili\Spear\Contracts\Data;
use Giunashvili\Spear\Handlers\CppHandler;

class Spear
{
	private array $handlers = [
		'cpp'  => CppHandler::class,
	];

	public function __construct(private string $language = 'cpp')
	{}

	public function execute(string $code, string $input = ''): Data
	{
		$handlerClass = $this->getHandler();
		$handler = new $handlerClass;
		if (!is_callable($handler))
		{
			throw new \Exception('Invalid handler provided!');
		}
		return $handler($code, $input);
	}

	public function handler(string $language): self
	{
		$this->language = $language;
		return $this;
	}

	private function getHandler(): string
	{
		return $this->handlers[$this->language];
	}
}
