# tainterscan

Using phpparser lib, this .php which tries to identify where user input ("tainted" like $_GET) reach dangerous sinks (like shell_exec) without sanitization.

This script was born after reading Wooyun blog .php scanner simple example and trying to modify it.

Compared to RIPS, WAP.jar or similar scanner, this script will try to be simpler so anyone can hack into it, support tainted classes / methods / inputs and avoid false positives.

tainted = under user control

How to use:

   `php tainterscan.php test/simple.php`

# plan

1. Create a network of connections
2. Find routes which indicate vulnerabilities

