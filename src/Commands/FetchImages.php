<?php

namespace Redberry\Spear\Commands;

use Illuminate\Console\Command;

class FetchImages extends Command
{
	protected $signature = 'spear:pull {image?}';

	protected $description = 'Fetch docker images';

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

	private function fetchImage($image)
	{
		switch ($image) {
			case 'node':
				$nodeVersions = [
					'14' => 'node:14',
					'16' => 'node:16',
					'17' => 'node:17',
					'18' => 'node:18',
				];

				$this->runExecForImages($nodeVersions);
				break;
			case 'cpp':
				$cppVersions = [
					'14' => 'giunashvili/cpp',
				];

				$this->runExecForImages($cppVersions);
				break;
			case 'csharp':
				$cSharpVersions = [
					'6'    => 'mono:6',
					'6.10' => 'mono:6.10',
					'6.12' => 'mono:6.12',
				];

				$this->runExecForImages($cSharpVersions);
				break;
			case 'go':
				$goVersions = [
					'1'    => 'golang:1',
					'1.17' => 'golang:1.17',
					'1.18' => 'golang:1.18',
				];

				$this->runExecForImages($goVersions);
				break;
			case 'java':
				$javaVersions = [
					'11' => 'openjdk:11',
				];

				$this->runExecForImages($javaVersions);
				break;
			case 'perl':
				$perlVersions = [
					'5'    => 'perl:5',
					'5.34' => 'perl:5.34',
				];

				$this->runExecForImages($perlVersions);
				break;
			case 'php':
				$phpVersions = [
					'8' => 'giunashvili/php',
				];

				$this->runExecForImages($phpVersions);
				break;
			case 'python':
				$pythonVersions = [
					'3.7'      => 'python:3.7',
					'3.8'      => 'python:3.8',
					'3.9'      => 'python:3.9',
					'3.10'     => 'python:3.10',
					'3.11-rc'  => 'python:3.11-rc',
				];

				$this->runExecForImages($pythonVersions);
				break;
			case 'ruby':
				$rubyVersions = [
					'2'      => 'ruby:2',
					'3'      => 'ruby:3',
					'3.1'    => 'ruby:3.1',
					'3.2-rc' => 'ruby:3.2-rc',
				];

				$this->runExecForImages($rubyVersions);
				break;
			case 'rust':
				$rustVersions = [
					'1' => 'rust:1',
				];

				$this->runExecForImages($rustVersions);
				break;
			default:
				$this->error(" This image doesn't exist: $image ");
		}
	}

	private function fetchAllImages()
	{
		foreach ($this->languages as $language)
		{
			$this->fetchImage($language);
		}
		$this->info('All images have been successfully loaded.');
	}

	private function runExecForImages($versions)
	{
		$output = null;
		$retval = null;

		foreach ($versions as $version)
		{
			echo "Loading...\n";
			exec('docker pull ' . $version, $output, $retval);
			echo "Returned with status $retval and output:\n";
			print_r($output);
			$this->info($version . ' image has been loaded.');
			$output = null;
		}
	}
}
