<?php

# class declaration test which need to be detected and DangerousClass needs to be stored

class DangerousClass {
   var $prop ="";

   public function dangerousmethod() {

	echo("method called\n");
	echo("prop is   ... :");
	print(var_dump($this-> prop));

	echo(shell_exec($this -> prop));

   }

}
