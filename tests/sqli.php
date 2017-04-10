<?php

# sqli examples

$var = $_POST['var'];
mysql_query("SELECT * FROM sometable WHERE id = $var");

$sql="INSERT INTO Persons (FirstName, LastName, Age) VALUES ('$_POST[firstname]','$_POST[lastname]','$_POST[age]')";
