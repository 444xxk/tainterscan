<?php

# lib
require("vendor/autoload.php");
use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
require __DIR__.'/conf/input.php';


echo "v0.00 PHP simple tainterscanner\n";
echo "usage $argv[0] file.php [debug]\n\n\n";


# getting the file to scan
# TODO scan a folder recursively
$code = file_get_contents($argv[1]);

# start phpparser
$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP7);



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


# key is the element and item is the value of the element
function walk_phpparser_array($phpparserarray)
{
$stack = array();

 foreach ($phpparserarray as $key => $item)
 {
 print "NEW BRANCH, so a new stack is created \n!";
 unset($stack);
 $stack = array();
 array_push($stack,$item);

 $stack = check_user_input($item, $key,$stack);
 }
}

# item is the value, key is the name of the element
function check_user_input($item, $key, $stack)
{
# check tainting
 is_it_tainted($item,$key,$stack);

 if (is_object($item) || is_array($item))
 {

 is_it_tainted($item,$key,$stack);
 foreach ($item as $subkey => $subitem)
 {
 array_push($stack,$item);
 $stack = check_user_input($subitem,$subkey,$stack);
 }
}

return $stack;
}



# function checking user input
function is_it_tainted($value,$key,$stack)
{

  # replace with all user inputs source

  $inputArr = UserInput::getUserInput();
  if (in_array($value,$inputArr))
  {
    {
    echo "WARNING ! Tainted value detected. \n";
    print "Detected tainted source : $value \n";
    print "The stack to here is: \n";
    print_r($stack[0]);

    if ($debug == true){ print "[DEBUG] full stack"; var_dump($stack);}

    # need to check if it s always build like this in phpparser first
    # print a pretty path to where we are
    # print "Calling function : ";
    # $function = $stack[0] -> expr -> parts[0];
    # print($function);
    # print "with arguments : ";
    # print($stack[0]["expr"]["args"]["value"]["var"]["name"]);
    # print "this function is tainted";

    dangerous_sink($stack[0]);
    unset($stack);
    }
  }
}




function is_sanitized($array)
{
# if the stack goes through a sanitizer we stop
}


function dangerous_sink($stack)
{
# need to walk the array
foreach ($stack as $key => $item)
{
  # add dangerous functions based on config
  if ($item == "shell_exec")
  {
    print "Found a dangerous function (aka sink) $item tainted with user input.";
  }
}

function vuln_description($input,$sink)
{
  print "$_GET linked to echo gives XSS;";
# linking $input to $sink gives X vuln;
# example $_GET to echo  is XSS vulnerability;
}

};
