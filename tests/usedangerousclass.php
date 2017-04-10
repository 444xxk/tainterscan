<?php

# testing detection of code using flagged as dangerous class / methods

include("DangerousClass.php");

$x = $_GET[input];

$object = new DangerousClass();
$object -> prop = $x;
$object -> dangerousmethod();
