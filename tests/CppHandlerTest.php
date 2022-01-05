<?php

namespace Giunashvili\Spear\Tests;

use Giunashvili\Spear\Spear;
use PHPUnit\Framework\TestCase;

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

	public function test_code_is_working(): void
	{
		$spear = new Spear;

		$data = $spear->execute($this->rightCode, '12');
		$this->assertEquals(24, +$data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
	}

	public function test_code_has_syntax_errors(): void
	{
		$spear = new Spear;
		$data = $spear->execute($this->erroredCode, '117');
		$this->assertNotEquals(0, $data->getResultCode());
	}
}
