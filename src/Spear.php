<?php

namespace Giunashvili\Spear;

use Giunashvili\Spear\Interfaces\Data;
use Giunashvili\Spear\Handlers\CppHandler;
use Giunashvili\Spear\Handlers\NodeHandler;
use Giunashvili\Spear\Handlers\PHPHandler;

class Spear
{
	const CPP = 'cpp';

	const NODE_14 = 'node:14';

	const PHP_8 = 'php:8.1';

	private array $handlers = [
		self::CPP     => CppHandler::class,
		self::NODE_14 => NodeHandler::class,
		self::PHP_8   => PHPHandler::class,
	];

	public function __construct(private string $language = self::CPP)
	{
	}

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
