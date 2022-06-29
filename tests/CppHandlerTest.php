<?php

namespace Redberry\Spear\Tests;

use Exception;
use Redberry\Spear\Facades\Spear;
use Tests\TestCase;

class CppHandlerTest extends TestCase
{
	private string $rightCode = <<<END
        #include <iostream>
        
        using namespace std;

        int a;

        int main() {
            cin >> a;

            cout << 2 * a;
        }
    END;

	private string $erroredCode = <<<END
        #include <iostream>
            
        using namespace std;

        int a

        int main() {
            cin >> a;

            cout << 2 * a;
        }
    END;

	public function test_cpp_default_version_code_is_working(): void
	{
		exec('docker pull giunashvili/cpp');

		$data = Spear::cpp()->execute($this->rightCode, '12');
		$this->assertEquals(24, +$data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
	}

	public function test_cpp_14_code_is_working(): void
	{
		exec('docker pull giunashvili/cpp');

		$data = Spear::cpp('14')->execute($this->rightCode, '12');
		$this->assertEquals(24, +$data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
	}

	public function test_cpp_default_version_code_has_syntax_errors(): void
	{
		exec('docker pull giunashvili/cpp');

		$data = Spear::cpp()->execute($this->erroredCode, '117');
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_cpp_14_code_has_syntax_errors(): void
	{
		exec('docker pull giunashvili/cpp');

		$data = Spear::cpp('14')->execute($this->erroredCode, '117');
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_when_cpp_default_version_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'giunashvili/cpp') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::cpp()->execute($this->rightCode, '14');
	}

	public function test_when_cpp_14_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'giunashvili/cpp') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::cpp('14')->execute($this->rightCode, '14');
	}

	public function test_cpp_with_incorrect_version(): void
	{
		$this->expectException(Exception::class);
		Spear::node('20')->execute($this->rightCode);
	}
}
