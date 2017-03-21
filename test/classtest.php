<?php

include("DangerousClass.php");

$x = $_GET[input]; 

$object = new DangerousClass();
$object -> prop = $x;  
$object -> dangerousmethod(); 

