#!/usr/bin/env php
<?php
function usage($exitCode = 0) {
    printf("Usage:\n");
    printf("%s FILE\n", $_SERVER['argv'][0]);
    exit($exitCode);
}

require_once __DIR__ . '/../src/autoload.php';

if(empty($_SERVER['argv'][1])) {
    usage(-1);
}

$file = $_SERVER['argv'][1];

try {
    $parser = new \Meander\PHP\Parser\PhpParser();
    $root = $parser->parse(new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenize(file_get_contents($file))));

    $xml = new \Meander\PHP\Compiler\XmlCompiler();
    $walker = new \Meander\PHP\Node\Traverser($xml);
    $walker->traverse($root);

    echo $xml;
} catch(Exception $e) {
    echo $e->getMessage();
}
