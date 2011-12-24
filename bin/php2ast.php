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
    $parser = new \Mystique\PHP\Parser\PhpParser();
    $root = $parser->parse(new \Mystique\PHP\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenize(file_get_contents($file))));

    $xml = new \Mystique\PHP\Compiler\AstToXml();
    $walker = new \Mystique\PHP\Node\Traverser($xml);
    $walker->traverse($root);

    echo $xml;
} catch(Exception $e) {
    echo $e->getMessage();
}
