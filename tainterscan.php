<?php 
require("vendor/autoload.php"); 
use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

$code = file_get_contents($argv[1]);
 
//echo "Node Dumper\n";

$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP7);
$nodeDumper = new PhpParser\NodeDumper;

try {
    $stmts = $parser->parse($code);
//    var_dump($stmts);
    echo $nodeDumper->dump($stmts), "\n";
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}; 

// var_dump($stmts);

function test_print($item, $key)
{
   echo "key is "; 
// var_dump()

    echo "value is "; 

// var_dump 

//phpscanner() 

    echo "$key holds $item\n";
}

echo "walk recursive\n"; 

array_walk_recursive($stmts, 'test_print');

//$prettyPrinter = new PrettyPrinter\Standard();
//echo $prettyPrinter->prettyPrintFile($stmts);
