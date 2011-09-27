<?php

namespace MeanderTest\PHP;

use \Meander\PHP\Lint;
use PHPUnit_Framework_TestCase;

class LintTest extends PHPUnit_Framework_TestCase {
    function testLinting() {
        $this->assertTrue(Lint::lint('<?php echo "w00t!";'));
        $this->assertFalse(Lint::lint('<?php this should cause an error!'));
    }


    function testLintingPhp() {
        $this->assertTrue(Lint::lintPhp('echo "w00t!";'));
        $this->assertFalse(Lint::lintPhp('<?php echo "w00t!";'));
    }
}