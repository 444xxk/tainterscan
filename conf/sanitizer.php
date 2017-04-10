<?php
class Sanitizer
{

  public static function getSanitizer()
  {
    return array_merge(
      self::$BOOL,
      self::$GENERAL,
      self::$XSS,
      self::$SQL,
      self::$PREG,
      self::$FILE,
      self::$EXEC,
      self::$XPATH
    );
  }

  //boolean sanitizer
  public static $BOOL = array(
	'is_double',
	'is_float',
	'is_real',
	'is_long',
	'is_int',
	'is_integer',
	'is_numeric',
	'ctype_alnum',
	'ctype_alpha',
	'ctype_cntrl',
	'ctype_digit',
	'ctype_xdigit',
	'ctype_upper',
	'ctype_lower',
	'ctype_space',
	'in_array',
	'preg_match',
	'preg_match_all',
	'fnmatch',
	'ereg',
	'eregi'
);

  //General sanitizer
  public static $GENERAL = array(
	'intval',
	'floatval',
	'doubleval',
	'filter_input',
	'urlencode',
	'rawurlencode',
	'round',
	'floor',
	'strlen',
	'hexdec',
	'strrpos',
	'strpos',
	'md5',
	'sha1',
	'crypt',
	'crc32',
	'hash',
	'base64_encode',
	'ord',
	'sizeof',
	'count',
	'bin2hex',
	'levenshtein',
	'abs',
	'bindec',
	'decbin',
	'hexdec',
	'rand',
	'max',
	'min'
);

//xss sanitizer
public static $XSS = array(
  'htmlentities',
	'htmlspecialchars'

);

//SQL sanitizer
public static $SQL = array(
  'addslashes',
	'dbx_escape_string',
	'db2_escape_string',
	'ingres_escape_string',
	'maxdb_escape_string',
	'maxdb_real_escape_string',
	'mysql_escape_string',
	'mysql_real_escape_string',
	'mysqli_escape_string',
	'mysqli_real_escape_string',
	'pg_escape_string',
	'pg_escape_bytea',
	'sqlite_escape_string',
	'sqlite_udf_encode_binary'
);

//reg sanitizer
public static $PREG = array(
	'preg_quote'
);

//file operation sanitizer
public static $FILE = array(
	'basename',
	'pathinfo'
);

//exe sanitizer
public static $EXEC = array(
	'escapeshellarg',
	'escapeshellcmd'
);

//xpath sanitizer
public static $XPATH = array(
	'addslashes'
);




}
