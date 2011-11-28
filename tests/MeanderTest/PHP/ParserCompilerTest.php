<?php
namespace MeanderTest\PHP;

class ParserCompilerTest extends \MeanderTest\TestCase {
    function setUp() {
        $this->parser = new \Meander\PHP\Parser\FileParser();
        $this->compiler = new \Meander\Compiler\Compiler();
    }

    /**
     * @dataProvider files
     * @param $file
     * @return void
     */
    function testThatCompilingParsedDoesNotAffectSyntax($file) {
        $this->assertSyntaxEquals(
            file_get_contents($file),
            $this->compiler->compile($this->parser->parse(new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenize(file_get_contents($file)))))->result
        );
    }


    function files() {
        return array_map(
            function(\SplFileInfo $f) { return array($f->getPathName()); },
            iterator_to_array(
                new \RegexIterator(
                    new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . '/../../../')),
                    '/\.php$/'
                )
            )
        );
    }
}