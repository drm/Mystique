<?php

function usage($exitCode = 0, $err = null) {
    if($err) {
        fprintf(STDERR, "Error: %s\n", $err);
    }
    printf("Usage:\n");
    printf("%s FILE TYPE\n", $_SERVER['argv'][0]);
    exit($exitCode);
}

require_once __DIR__ . '/../src/autoload.php';

if(empty($_SERVER['argv'][1]) || empty($_SERVER['argv'][2])) {
    usage(-1);
}

$file = $_SERVER['argv'][2];

try {
    $lang = new \Mystique\PHP\Lang();
    $root = $lang->parseFile($file);

    $finder = new \Mystique\Common\Inspector\FilterIterator(
        new RecursiveIteratorIterator(new \Mystique\Common\Ast\Iterator($root), RecursiveIteratorIterator::SELF_FIRST),
        new \Mystique\PHP\Inspector\Matcher\FunctionCall('file_get_contents')
    );

    $compiler = new \Mystique\Common\Compiler\Compiler();

    foreach($finder as $node) {
        $slice = $node->getTokenSlice();
        if(!$slice) {
            throw new LogicException("Node " . get_class($node) . " has no slice!");
        }
        printf("%s %s %d\n", $compiler->compile($node)->result, $slice->stream->getFilename(), $slice->getLineNumber());
        $compiler->reset();
    }
} catch(Exception $e) {
    printf("Error while processing file %s: ", $file);
    echo $e->getMessage(), "\n";
//    echo $e->getTraceAsString();
    return -1;
}