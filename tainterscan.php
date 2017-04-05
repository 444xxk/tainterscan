<?php

// lib
require("vendor/autoload.php");
use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

echo "v0.00 PHP simple tainterscanner \n";
echo "usage $argv[0] file.php \n\n\n";

$code = file_get_contents($argv[1]);



$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP7);
//$nodeDumper = new PhpParser\NodeDumper;

echo "[DEBUG] Pretty print Node dumper from PHPParser \n\n";
try {
    $stmts = $parser->parse($code);
    var_dump($stmts);
    //echo $nodeDumper->dump($stmts);
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
  };




// START SCAN FUNCTION HERE , entry is an array
echo "Searching for tainted inputs by walking recursively the PHPParser array \n\n";

$stack = array();
walk_phpparser_array($stmts);



function walk_phpparser_array($phpparserarray)
{
global $stack;
foreach ($phpparserarray as $key => $item)
{
print "NEW BRANCH \n!";
//  echo "KEY:";
//var_dump($item);
unset($stack);
$stack = array();
//var_dump($value);
check_user_input($item, $key);
}
}



// walk array to check input
function check_user_input($item, $key)
{
global $stack;
array_push($stack,$item);
is_it_tainted($item);


if (is_object($item) || is_array($item))
{
is_it_tainted($item);
foreach ($item as $subkey => $subitem)
{
check_user_input($subitem,$subkey);
}
}


} // end of check user input function



// checking user input
function is_it_tainted($value)
{

global $stack;

  if ($value == "_GET")
  {
    {
  // replace with all user inputs source
    echo "BETA MODE ***************** !!! IS TAINTED DETECTED !!! ***************** >>>> \n";
    print "detected $value \n";
    echo "the stack to here is ...";
    var_dump($stack);
    unset($stack);
  }
  }


}





function dangerous_sink($value, $key)
{

if ($value == "shell_exec")
{
  echo "found sink >>>>>>>>>>>>>>>>>> \n";
  var_dump($value);
}


};
