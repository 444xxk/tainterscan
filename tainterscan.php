<?php 

// lib 
require("vendor/autoload.php"); 
use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;


echo "v0.00 PHP simple tainterscanner \n"; 
echo "usage $argv[0] file.php \n\n\n"; 

$code = file_get_contents($argv[1]);
 
//echo "Node Dumper\n";

$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP7);
$nodeDumper = new PhpParser\NodeDumper;

echo "[DEBUG] Pretty print Node dumper from PHPParser \n\n"; 
try {
    $stmts = $parser->parse($code);
    var_dump($stmts);
//    echo $nodeDumper->dump($stmts), "\n";
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
};


// var_dump($stmts);

function is_tainted($item, $key)
{
echo "[DEBUG] function is_tainted started \n"; 

// debug 
echo "[DEBUG] var dumps of the item \n";
var_dump($item); 
//var_dump($key); 
//the array contains an object so need to call recursively the function is_tainted on it :( 

if (is_object($item)) 
{ foreach ($item as $objectkey => $value) {
	// $item an object and we are parsing it recursively; 
	if ($value == "_GET") // replace with all user inputs source 
// we need to code a function for taint detection
// need to get the full path of this input (Obj > x > y > z); 
	{ 
	echo "IS TAINTED DETECTED !!! >>>> "; 
	var_dump($value); 
	echo ("in the objet " . var_dump($item)); var_dump($item -> $objectkey); 
	}
	
array_walk_recursive($item,"is_tainted");
}}; 



}

echo "Searching for tainted inputs by walking recursively the PHPParser array \n"; 

//echo(array_key_exists("_GET",$stmts));

// SCAN FUNCTIOM HERE 
array_walk_recursive($stmts, 'is_tainted');

//$prettyPrinter = new PrettyPrinter\Standard();
//echo $prettyPrinter->prettyPrintFile($stmts);
