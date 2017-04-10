//XSS1
<?php
$name = $_REQUEST ['name'];
?>
<html><body>Hello, <?php echo $name; ?>!</body></html>

//XSS2
<?php
$name = $_REQUEST ['name'];
?>
<html><body>Hello, <?php echo "lol"; ?>!</body></html>
