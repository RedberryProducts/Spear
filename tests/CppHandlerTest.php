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
		$data = Spear::cpp()->execute($this->rightCode, '12');
		$this->assertEquals(24, +$data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
	}

	public function test_cpp_14_code_is_working(): void
	{
		$data = Spear::cpp('14')->execute($this->rightCode, '12');
		$this->assertEquals(24, +$data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
	}

	public function test_cpp_default_version_code_has_syntax_errors(): void
	{
		$data = Spear::cpp()->execute($this->erroredCode, '117');
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_code_14_has_syntax_errors(): void
	{
		$data = Spear::cpp('14')->execute($this->erroredCode, '117');
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_cpp_with_incorrect_version(): void
	{
		$this->expectException(Exception::class);
		Spear::node('20')->execute($this->rightCode);
	}
}
