<?php

namespace Redberry\Spear;

use Exception;
use Redberry\Spear\Handlers\PHPHandler;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Handlers\NodeHandler;
use Redberry\Spear\Interfaces\Handler;

class Spear
{
	/**
	 * Select default handler.
	 */
	private Handler $selectedHandler;

	/**
	 * Returns execute code if it is callable otherwise throw error.
	 *
	 * @throws Exception
	 */
	public function execute(string $code, string $input = ''): Data
	{
		$handler = $this->getHandler();

		if (!is_callable($handler))
		{
			throw new Exception('Invalid handler provided!');
		}
		return $handler($code, $input);
	}

	/**
	 * Set programming language handler.
	 */
	public function handler(Handler $handler): self
	{
		$this->selectedHandler = $handler;
		return $this;
	}

	/**
	 * Get selected programming language handler.
	 */
	private function getHandler(): Handler
	{
		return $this->selectedHandler;
	}

	/**
	 * Use node handler.
	 *
	 * @throws Exception
	 */
	public function node(string $version = '14'): self
	{
		$handler = new NodeHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use php handler.
	 */
	public function php(string $version = '8'): self
	{
		$handler = new PHPHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use cpp handler.
	 */
	public function cpp(): self
	{
		$this->handler(self::CPP);
		return $this;
	}

	/**
	 * Use python handler.
	 */
	public function python(): self
	{
		$this->handler(self::PYTHON_3);
		return $this;
	}

	/**
	 * Use ruby handler.
	 */
	public function ruby(): self
	{
		$this->handler(self::RUBY_3);
		return $this;
	}

	/**
	 * Use rust handler.
	 */
	public function rust(): self
	{
		$this->handler(self::RUST_1);
		return $this;
	}

	/**
	 * Use c# handler.
	 */
	public function cSharp(): self
	{
		$this->handler(self::C_SHARP);
		return $this;
	}

	/**
	 * Use go handler.
	 */
	public function go(): self
	{
		$this->handler(self::GO_LANG);
		return $this;
	}

	/**
	 * Use java handler.
	 */
	public function java(): self
	{
		$this->handler(self::JAVA);
		return $this;
	}

	/**
	 * Use perl handler.
	 */
	public function perl(): self
	{
		$this->handler(self::PERL);
		return $this;
	}
}
