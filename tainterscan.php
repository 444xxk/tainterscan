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

#tainted variables global vars
global $taintedvariables;
$stack = array();

# counting branches
$branches = 0;

 foreach ($phpparserarray as $key => $item)
 {
 $branches = $branches +1;
 $branchtype = $item->getType();
 print "BRANCH #$branches of type $branchtype, new stack is created. \n";
 # new stack
 unset($stack);
 $stack = array();
 # push first item of the branch to stack
 array_push($stack,$item);
 $stack = check_user_input($item, $key, $stack);
 }
}


# function which checks if there is the branch is tainted by user input
# item is the value, key is the name of the element
function check_user_input($item, $key, $stack)
{
# TODO check tainting directly on the item, we need to confirm its useful
 is_it_tainted($item,$key,$stack);

# if is object or array we continue to parse it recursively
 if (is_object($item) || is_array($item))
{
 foreach ($item as $subkey => $subitem)
 {
# push the stack again to know where we are while browsing the array
 array_push($stack,$subitem);
 $stack = check_user_input($subitem,$subkey,$stack);
 }
}
return $stack;
}



# function checking if it is tainted by user input
function is_it_tainted($value,$key,$stack)
{
 global $debug;
 global $taintedvariables;

  # check user input, save tainted var if Expr_Assign, test sink and sanitize
  $inputArr = UserInput::getUserInput();
  if (in_array($value,$inputArr) or in_array($value,$taintedvariables))
  {
    {
    echo "TAINT SOURCE FOUND: a taint source (taint) $value was found. \n";
    print "The stack to this source is: \n";
    print_r($stack);
    # testing
    print("The PHPParser Node type is (important to understand the synthax tree): ");
    print($stack[0]->getType());
    print("\n");
    if ($stack[0]->getType()=="Expr_Assign")
    {
    print("Storing the tainted variable for later use because it is assigned:");
    print($stack[0]->var->name);
    array_push($taintedvariables,$stack[0]->var->name);
    print("\n");
    }
    # debug
    if ($debug == true){ print "[DEBUG] full stack \n"; var_dump($stack);}

# VULN SCAN starts here
$sink=false;
$sink = is_dangerous_sink($stack,$value);
# TODO need to double check this logic test
    if (($sink) and !(is_sanitized($stack,$value)))
    {
      print "VULNERABILITY FOUND: the tainted input $value goes to a dangerous sink function $sink without sanitization \n";
      # need to output the source code based on the object start line number  to end line number
      print "Vulnerability path: \n";
      print_r(array_values($stack));
    }
    # clean the stack
    unset($stack);
# vuln scan stops here
    }
  }
}


# function checking if stack is sanitized
function is_sanitized($stacktowalk,$taintsource)
{


foreach ($stacktowalk as $key => $item)
{
  # TODO add sanitized function based on config or pre-scan
  if ($item == "escapeshellarg")
  {
    print "SANITIZER FOUND: a sanitizer function (san) $item sanitized user input $taintsource . \n";
  }
}
}

# this function checks if the tainted input goes to a dangerous sink function
# you give a stack to walk back and the taintsource for printing purposes only
function is_dangerous_sink($stacktowalk,$taintsource)
{
# need to make a difference between FuncCall and other ?

# need to detect include with
# if object is PHP Parser \ Object \ Include
# if object is PHP Parser \ Object \ FuncCall

foreach ($stacktowalk as $key => $item)
{
  # add dangerous functions based on config

  # echo vuln
 if (get_class($item) == "PhpParser\Node\Stmt\Echo_")
 {
 $printable_item = $item->getType();
 print "DANGEROUS FUNCTION FOUND: a dangerous function (dan) $printable_item was found to be tainted by user input $taintsource.\n";
 return $printable_item;
 }


  # include vuln



  # exit



  # die




  $sinksArr = Sinks::getSinks();
  if (in_array($item,$sinksArr))
  {
    # we need to return the sink
    print "DANGEROUS FUNCTION FOUND: a dangerous function (dan) $item was found to be tainted by user input $taintsource. \n";
    return $item;
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
    if (@$argv[2] == "debug"){ $debug = true; echo "[DEBUG] Printing the full PHPParser array :\n"; var_dump($stmts);}
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
  };


# START SCAN FUNCTION HERE , entry is an array from phpparser
echo "Searching for tainted inputs by walking recursively the PHPParser array \n\n";
# keeping tainted variables in reference
# testing
$taintedvariables = array();
# main function start
walk_phpparser_array($stmts);

if ($debug == true)
{
  print("[DEBUG] tainted vars found: \n"); var_dump($taintedvariables);
}

# END
