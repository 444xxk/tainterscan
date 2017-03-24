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
    //var_dump($stmts);
    echo $nodeDumper->dump($stmts), "\n";
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
  };

//echo(array_key_exists("_GET",$stmts));
echo "Searching for tainted inputs by walking recursively the PHPParser array \n"; 

// SCAN FUNCTIOM HERE
//**
//array_walk_recursive($stmts, 'test_print');
array_walk($stmts, 'is_tainted');





function is_tainted($item, $key)
{

//echo "[DEBUG] function is_tainted started on \n";
//var_dump($item);
//echo "DEBUG start taint scan \n"; 
//if ($item == "_GET"){ echo "detection without iteration !! TAINTED !!\n"; } 

foreach ((array)$item as $objectkey => $value) {
	//echo "iterating the array for value scan ...\n"; 
	if ($value == "_GET"){
// replace with all user inputs source 
// we need to code a function for taint detection
// need to get the full path of this input (Obj > x > y > z);
	echo "IS TAINTED DETECTED !!! >>>> ";
	var_dump($value); 
	echo ("in the objet " . var_dump($item));
        //var_dump($item -> $objectkey);
        var_dump($key); 						}
}; 


if (is_object($item))
{
	//echo "this is an object !\n";
	//echo "[DEBUG] recursion on object \n";	
	array_walk($item,'is_tainted');
};

if (is_array($item))
{ 
	array_walk_recursive($item,'is_tainted');
	//echo "[DEBUG] recursion on array \n";	    
}; 
	    
 
}; // end of function  




// function test_print($item, $key)
// {
//     //echo "$key holds $item\n";
//     var_dump($item);
// }


function is_user_tainted()
{
// $_ variables , load from config etc ...
} 


