<?php

# testing detection of function 

function test($a){
  shell_exec($a);
}


test($_GET["i"]);


//Function inside function
//$data="10";
function function1($data){
    function function2($data){
        return $data*2;
    }
    return function2($data)*4;
}
echo function1($data);
