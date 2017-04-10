<?php

# lib
require("vendor/autoload.php");
use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;


echo "v0.00 PHP simple tainterscanner\n";
echo "usage $argv[0] file.php \n\n\n";

# getting the file to scan
# TODO scan a folder recursively
$code = file_get_contents($argv[1]);

# Start phpparser
$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP7);

# if you need Nodedumper view
# $nodeDumper = new PhpParser\NodeDumper;



try {
    $stmts = $parser->parse($code);
    echo "[DEBUG] Printing the full PHPParser array :\n";
    # var_dump($stmts);
    # echo $nodeDumper->dump($stmts);
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
  };




# START SCAN FUNCTION HERE , entry is an array from phpparser
echo "Searching for tainted inputs by walking recursively the PHPParser array \n\n";

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
# debug
#var_dump($value);
$stack = check_user_input($item, $key,$stack);
}
}



// walk array to check input
function check_user_input($item, $key, $stack)
{

# create the stack to know where we are
array_push($stack,$item);

# check tainting
is_it_tainted($item,$stack);


if (is_object($item) || is_array($item))
{
is_it_tainted($item,$stack);
foreach ($item as $subkey => $subitem)
{
$stack = check_user_input($subitem,$subkey,$stack);
}
}

return $stack;

} // end of check user input function



// checking user input
function is_it_tainted($value,$stack)
{
  $inputArr = UserInput::$V_USERINPUT;

  if (in_array($value,$inputArr))
  {
    {
  // replace with all user inputs source
    echo "IS TAINTED DETECTED !!! >>>> \n";
    print "detected tainted : $value \n";
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
