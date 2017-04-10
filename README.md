# tainterscan

Using phpparser lib, this .php script which tries to identify where user input ("tainted" like $_GET) reach dangerous sinks (like shell_exec) without sanitization.

This script was born after reading Wooyun blog .php scanner simple example and trying to modify it.

Compared to RIPS, WAP.jar or similar scanner, this script will try to be simpler so anyone can hack into it, support tainted classes / methods / inputs and avoid false positives.

tainted = under user control

How to use:

   php tainterscan.php test/simple.php

# plan

1. Create a db of dangerous classes
2. Match all inputs based on conf/input.php with the classes
3. If there is a match of dangerous class and input, not sanitized, then it's vulnerable
4. If point 3 applies but there is some strange sanitization then flag it separately
5. Additional checks: if not in a class, but still tainted

