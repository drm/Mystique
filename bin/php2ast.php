<?php

use Mystique\Common\Ast\AstToXml;
use Mystique\Common\Ast\Traverser;

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
    $lang = new \Mystique\PHP\Lang();
    $parser = new \Mystique\PHP\Parser\PhpParser();
    $root = $parser->parse(new \Mystique\Common\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenize(file_get_contents($file))));

    $xml = new AstToXml();
    $walker = new Traverser($xml);
    $walker->traverse($root);

    echo $xml;
} catch(Exception $e) {
    echo $e->getMessage();
}
