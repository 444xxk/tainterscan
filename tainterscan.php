<?php

# lib
require("vendor/autoload.php");
use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
require __DIR__.'/conf/input.php';
require __DIR__.'/conf/sink.php';


echo "v0.00 PHP simple tainterscanner\n";
echo "usage $argv[0] file.php [debug] \n\n\n";


# getting the file to scan
# TODO scan a folder recursively
$code = file_get_contents($argv[1]);

# start phpparser
$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP7);

$debug = false;

try {
    $stmts = $parser->parse($code);
    if ($argv[2] == "debug"){ $debug = true; echo "[DEBUG] Printing the full PHPParser array :\n"; var_dump($stmts);}
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
  };


# START SCAN FUNCTION HERE , entry is an array from phpparser
echo "Searching for tainted inputs by walking recursively the PHPParser array \n\n";
# main function
walk_phpparser_array($stmts);




############## FUNCTIONS

# key is the element and item is the value of the element
function walk_phpparser_array($phpparserarray)
{
$stack = array();
# counting branches
$branches = 0;

 foreach ($phpparserarray as $key => $item)
 {
 $branches = $branches +1;
 print "NEW BRANCH # $branches, new stack is created. \n";
 # new stack
 unset($stack);
 $stack = array();
 # push first item to stack
 array_push($stack,$item);
 $stack = check_user_input($item, $key, $stack);
 }
}

# function which checks if there is user input inside
# item is the value, key is the name of the element
function check_user_input($item, $key, $stack)
{
# check tainting
 is_it_tainted($item,$key,$stack);

 if (is_object($item) || is_array($item))
 {
 # useless call i think
 # is_it_tainted($item,$key,$stack);
 foreach ($item as $subkey => $subitem)
 {
 array_push($stack,$subitem);
 $stack = check_user_input($subitem,$subkey,$stack);
 }
}
return $stack;
}



# function checking user input
function is_it_tainted($value,$key,$stack)
{
 global $debug;
  # replace with all user inputs source

  $inputArr = UserInput::getUserInput();
  if (in_array($value,$inputArr))
  {
    {
    echo "WARNING ! Tainted value detected. \n";
    print "Detected tainted source : $value \n";
    print "The stack to here is: \n";
    print_r($stack);

    if ($debug == true){ print "[DEBUG] full stack \n"; var_dump($stack);}

    // print "calling function $stack[0]->exprs[1]->name with tainted input \n";

# if is_dangerous && ! is_sanitized then VULN FOUND

    is_dangerous_sink($stack);
    //is_sanitized($stack);

    unset($stack);
    }
  }
}


function is_sanitized($array)
{
# if the stack goes through a sanitizer we stop
}


function is_dangerous_sink($stack)
{
# need to walk the array


# if object is PHP Parser \ Object \ Include

# if object is PHP Parser \ Object \ FuncCall
foreach ($stack as $key => $item)
{
  # add dangerous functions based on config
  $sinksArr = Sinks::getSinks();
  if (in_array($item,$sinksArr))
  {
    print "VULNERABILITY FOUND: a dangerous function (sink) $item which is tainted by user input. \n";
  }
}



function vuln_info($input,$sink)
{
  print "$_GET linked to echo gives XSS";
# linking $input to $sink gives X vuln;
# example $_GET to echo  is XSS vulnerability;
}

};
