<?php

# lib
require("vendor/autoload.php");
use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
# conf
require __DIR__.'/conf/input.php';
require __DIR__.'/conf/sink.php';

#### BANNER
echo "v0.01 PHP simple tainterscanner\n";
echo "Usage: $argv[0] file.php [debug] \n\n\n";


############ FUNCTIONS

# this function walks the php parser array
function walk_phpparser_array($phpparserarray)
{
$stack = array();
# counting branches
$branches = 0;

 foreach ($phpparserarray as $key => $item)
 {
 $branches = $branches +1;
 print "BRANCH #$branches, new stack is created. \n";
 # new stack
 unset($stack);
 $stack = array();
 # push first item to stack
 array_push($stack,$item);
 $stack = check_user_input($item, $key, $stack);
 }
}


# function which checks if there is the branch is tainted by user input
# item is the value, key is the name of the element
function check_user_input($item, $key, $stack)
{
# check tainting directly on the item
 is_it_tainted($item,$key,$stack);

# if is object or array we continue to parse it
 if (is_object($item) || is_array($item))
{
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
    echo "TAINT SOURCE FOUND: a taint source (taint) $value was found. \n";
    print "The stack to this source is: \n";
    print_r($stack);

    if ($debug == true){ print "[DEBUG] full stack \n"; var_dump($stack);}

    // print "calling function $stack[0]->exprs[1]->name with tainted input \n";

# if is_dangerous && ! is_sanitized then VULN FOUND

    if ((is_dangerous_sink($stack,$value)) and !(is_sanitized($stack,$value)))
    {
      print "VULNERABILITY FOUND: the tainted input $value goes to a dangerous sink without sanitization";
      print "Vulnerability path:";
      var_dump($stack);
    }


    unset($stack);
    }
  }
}


# function checking if stack is sanitized
function is_sanitized($stacktowalk,$taintsource)
{


foreach ($stacktowalk as $key => $item)
{
  # add sanitized function based on config or pre-scan
  if ($item == "escapeshellarg")
  {
    print "SANITIZER FOUND: a sanitizer function (san) $item sanitized user input $taintsource . \n";
  }
}
}

# this function checks if the tainted input goes to a dangerous sink function
function is_dangerous_sink($stacktowalk,$taintsource)
{
# need to make a difference between FuncCall and other ?

# need to detect include with
# if object is PHP Parser \ Object \ Include
# if object is PHP Parser \ Object \ FuncCall

foreach ($stacktowalk as $key => $item)
{
  # add dangerous functions based on config
  $sinksArr = Sinks::getSinks();
  if (in_array($item,$sinksArr))
  {
    # we need to return the sink
    print "DANGEROUS FUNCTION FOUND: a dangerous function (dan) $item was found to be tainted by user input $taintsource . \n";
  }
}
}

# this function explains the found vulnerability
function explain_vuln($input,$sink)
{
  $vulnerabilitieskdb = array();
  print "$input linked to $sink and unsanitized gives XSS";
# linking $input to $sink gives X vuln;
# example $_GET to echo  is XSS vulnerability;
}

##### END FUNCTIONS



############ MAIN FUNCTION
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
# main function start
walk_phpparser_array($stmts);

# END
