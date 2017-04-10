<?php
class UserInput
{
	public static $USERINPUT = array(
		'_GET',
		'_POST',
		'_COOKIE',
		'_REQUEST',
		'_FILES',
		'_SERVER',
		'_ENV',
		'HTTP_GET_VARS',
		'HTTP_POST_VARS',
		'HTTP_COOKIE_VARS',
		'HTTP_REQUEST_VARS',
		'HTTP_POST_FILES',
		'HTTP_SERVER_VARS',
		'HTTP_ENV_VARS',
		'HTTP_RAW_POST_DATA',
		'argc',
		'argv'
	);

  public static $SERVER_PARAMS = array(
		'HTTP_ACCEPT',
		'HTTP_ACCEPT_LANGUAGE',
		'HTTP_ACCEPT_ENCODING',
		'HTTP_ACCEPT_CHARSET',
		'HTTP_CONNECTION',
		'HTTP_HOST',
		'HTTP_KEEP_ALIVE',
		'HTTP_REFERER',
		'HTTP_USER_AGENT',
		'HTTP_X_FORWARDED_FOR',
		'PHP_AUTH_DIGEST',
		'PHP_AUTH_USER',
		'PHP_AUTH_PW',
		'AUTH_TYPE',
		'QUERY_STRING',
		'REQUEST_URI',
		'PATH_INFO',
		'ORIG_PATH_INFO',
		'PATH_TRANSLATED',
		'PHP_SELF'
	);

  public static function getUserInput(){
		return array_merge(
					self::$USERINPUT ,
					self::$SERVER_PARAMS
				);
	}
}
