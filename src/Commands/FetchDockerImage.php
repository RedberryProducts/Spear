<?php

namespace Redberry\Spear\Commands;

use Illuminate\Console\Command;
use Redberry\Spear\Handlers\CppHandler;
use Redberry\Spear\Handlers\CSharpHandler;
use Redberry\Spear\Handlers\GoHandler;
use Redberry\Spear\Handlers\JavaHandler;
use Redberry\Spear\Handlers\NodeHandler;
use Redberry\Spear\Handlers\PerlHandler;
use Redberry\Spear\Handlers\PHPHandler;
use Redberry\Spear\Handlers\PythonHandler;
use Redberry\Spear\Handlers\RubyHandler;
use Redberry\Spear\Handlers\RustHandler;

class FetchDockerImage extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'spear:pull {image?}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch docker images';

	/**
	 * Languages array for fetching images.
	 */
	private array $languages = [
		'node',
		'cpp',
		'csharp',
		'go',
		'java',
		'perl',
		'php',
		'python',
		'ruby',
		'rust',
	];

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		if ($this->argument('image'))
		{
			$this->fetchImage($this->argument('image'));
		}
		else
		{
			$this->fetchAllImages();
		}
	}

	/**
	 * Checks if it exists images
	 */
	private function fetchImage($image)
	{
		switch ($image) {
			case 'node':
				$nodeVersions = NodeHandler::$versions;

				$this->runExecForImages($nodeVersions);
				break;
			case 'cpp':
				$cppVersions = CppHandler::$versions;

				$this->runExecForImages($cppVersions);
				break;
			case 'csharp':
				$cSharpVersions = CSharpHandler::$versions;

				$this->runExecForImages($cSharpVersions);
				break;
			case 'go':
				$goVersions = GoHandler::$versions;

				$this->runExecForImages($goVersions);
				break;
			case 'java':
				$javaVersions = JavaHandler::$versions;

				$this->runExecForImages($javaVersions);
				break;
			case 'perl':
				$perlVersions = PerlHandler::$versions;

				$this->runExecForImages($perlVersions);
				break;
			case 'php':
				$phpVersions = PHPHandler::$versions;

				$this->runExecForImages($phpVersions);
				break;
			case 'python':
				$pythonVersions = PythonHandler::$versions;

				$this->runExecForImages($pythonVersions);
				break;
			case 'ruby':
				$rubyVersions = RubyHandler::$versions;

				$this->runExecForImages($rubyVersions);
				break;
			case 'rust':
				$rustVersions = RustHandler::$versions;

				$this->runExecForImages($rustVersions);
				break;
			default:
				$this->error(" This image doesn't exist: $image ");
		}
	}

	/**
	 * Get languages and after that fetching them.
	 */
	private function fetchAllImages()
	{
		foreach ($this->languages as $language)
		{
			$this->fetchImage($language);
		}
		$this->info('All images have been successfully loaded.');
	}

	/**
	 * Issues an order to pull the docker image
	 */
	private function runExecForImages($versions)
	{
		$bar = $this->output->createProgressBar(count($versions));
		$bar->start();
		foreach ($versions as $version)
		{
			exec('docker pull ' . $version);
			$bar->advance();
			echo ' ' . $version . ' has been successfully loaded.';
		}
		$bar->finish();
		echo "\n";
	}
}
