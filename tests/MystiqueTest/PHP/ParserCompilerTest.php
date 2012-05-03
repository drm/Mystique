<?php
namespace MystiqueTest\PHP;

class ParserCompilerTest extends \MystiqueTest\TestCase {
    function setUp() {
        $this->lang = new \Mystique\PHP\Lang();
    }

    /**
     * @dataProvider files
     * @param $file
     * @return void
     */
    function testThatCompilingParsedDoesNotAffectSyntax($file) {
        $this->assertSyntaxEquals(
            // remove comments from source
            array_reduce(
                array_filter(
                    token_get_all(file_get_contents($file)),
                    function ($token) {
                        return !in_array($token[0], array(T_COMMENT, T_DOC_COMMENT));
                    }
                ),
                function ($a, $b) {
                    return $a . (isset($b[1]) ? $b[1] : $b);
                },
                ''
            ),
            $this->lang->getCompiler()->compile(
                $this->lang->getParser()->parse(
                    $this->lang->getTokenizer()->getTokens(
                        file_get_contents($file),
                        array(T_DOC_COMMENT, T_COMMENT, T_WHITESPACE)
                    )
                )
            )->result
        );
    }

    /**
     * @dataProvider files
     * @param $file
     * @return void
     */
    function testThatCompilingParsedRetainsComments($file) {
        $this->assertSyntaxEquals(
            file_get_contents($file),
            $this->lang->getCompiler()->compile(
                $this->lang->getParser()->parse(
                    $this->lang->getTokenizer()->getTokens(
                        file_get_contents($file),
                        array(T_DOC_COMMENT, T_COMMENT, T_WHITESPACE)
                    )
                )
            )->result
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