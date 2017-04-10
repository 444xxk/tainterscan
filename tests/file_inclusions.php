<?php
//RFI classic
include($_GET['file']);

//RFI limited
include($_GET['file'] . ".html");

//RFI static
include("http://mysite.loc/myscript.php");

//LFI classic
include("scripts/" . $_GET['file']);

//LFI limited
include("scripts/" . $_GET['file'] . ".html");

//test
?>
