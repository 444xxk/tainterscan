<?php

class UserInput
{
  public static function getSinks()
  {
    return array_merge(
	  self::$XSS,
	  self::$SQL,
          self::$XPATH,
          self::$HEADER,
          self::$UNSERI,
          self::$COMMEXE,
          self::$CODEXE,
          self::$FILEINC,
          self::$LDAP,
          self::$FILEDISC,
          self::$FILEMANI
    );
  }

  //XSS
  public static $XSS = array(
    'echo',
    'print',
    'print_r',
    'exit',
    'die',
    'printf',
    'vprintf',
  );

  //SQL Injection
  public static $SQL = array(
    'dba_open',
  	'dba_popen',
  	'dba_insert',
  	'dba_fetch',
  	'dba_delete',
  	'dbx_query',
  	'odbc_do',
  	'odbc_exec',
  	'odbc_execute',
  	'db2_exec',
  	'db2_execute',
  	'fbsql_db_query',
  	'fbsql_query',
  	'ibase_query',
  	'ibase_execute',
  	'ifx_query',
  	'ifx_do',
  	'ingres_query',
  	'ingres_execute',
  	'ingres_unbuffered_query',
  	'msql_db_query',
  	'msql_query',
  	'msql',
  	'mssql_query',
  	'mssql_execute',
  	'mysql_db_query',
  	'mysql_query',
  	'mysql_unbuffered_query',
  	'mysqli_stmt_execute',
  	'mysqli_query',
  	'mysqli_real_query',
  	'mysqli_master_query',
  	'oci_execute',
  	'ociexecute',
  	'ovrimos_exec',
  	'ovrimos_execute',
  	'ora_do',
  	'ora_exec',
  	'pg_query',
  	'pg_send_query',
  	'pg_send_query_params',
  	'pg_send_prepare',
  	'pg_prepare',
  	'sqlite_open',
  	'sqlite_popen',
  	'sqlite_array_query',
  	'arrayQuery',
  	'singleQuery',
  	'sqlite_query',
  	'sqlite_exec',
  	'sqlite_single_query',
  	'sqlite_unbuffered_query',
  	'sybase_query',
  	'sybase_unbuffered_query'
  );

  // XPath Injection
  public static $XPATH = array(
     'xpath_eval',
     'xpath_eval_expression',
     'xptr_eval'
  );

  // HTTP response splitting
  public static $HEADER = array(
     'header'
  );

  // Unserialize
  public static $UNSERI = array(
     'unserialize'
  );

  //Command execution
  public static $COMMEXE = array(
    'backticks',
    'exec',
    'expect_popen',
    'passthru',
    'pcntl_exec',
    'popen',
    'proc_open',
    'shell_exec',
    'system',
    'mail',
    'mb_send_mail',
    'w32api_invoke_function',
    'w32api_register_function'
  );

  // Code execution
  public static $CODEXE = array(
    	'array_diff_uassoc',
    	'array_diff_ukey',
    	'array_filter',
    	'array_intersect_uassoc',
    	'array_intersect_ukey',
    	'array_map',
    	'array_reduce',
    	'array_udiff',
    	'array_udiff_assoc',
    	'array_udiff_uassoc',
    	'array_uintersect',
    	'array_uintersect_assoc',
    	'array_uintersect_uassoc',
    	'array_walk',
    	'array_walk_recursive',
    	'assert',
    	'assert_options',
    	'call_user_func',
    	'call_user_func_array',
    	'create_function',
    	'dotnet_load',
    	'forward_static_call',
    	'forward_static_call_array',
    	'eio_busy',
    	'eio_chmod',
    	'eio_chown',
    	'eio_close',
    	'eio_custom',
    	'eio_dup2',
    	'eio_fallocate',
    	'eio_fchmod',
    	'eio_fchown',
    	'eio_fdatasync',
    	'eio_fstat',
    	'eio_fstatvfs',
    	'eval',
    	'event_buffer_new',
    	'event_set',
    	'iterator_apply',
    	'mb_ereg_replace',
    	'mb_eregi_replace',
    	'ob_start',
    	'preg_filter',
    	'preg_replace',
    	'preg_replace_callback',
    	'register_shutdown_function',
    	'register_tick_function',
    	'runkit_method_add',
    	'runkit_method_copy',
    	'runkit_method_redefine',
    	'runkit_method_rename',
    	'runkit_function_add',
    	'runkit_function_copy',
    	'runkit_function_redefine',
    	'runkit_function_rename',
    	'session_set_save_handler',
    	'set_error_handler',
    	'set_exception_handler',
    	'spl_autoload',
    	'spl_autoload_register',
    	'sqlite_create_aggregate',
    	'sqlite_create_function',
    	'stream_wrapper_register',
    	'uasort',
    	'uksort',
    	'usort',
    	'yaml_parse',
    	'yaml_parse_file',
    	'yaml_parse_url'
	);

  // File Inclusion
  public static $FILEINC = array(
    'include',
    'include_once',
    'parsekit_compile_file',
    'php_check_syntax',
    'require',
    'require_once',
    'runkit_import',
    'set_include_path',
    'virtual'
  );

  // LDAP Injection
  public static $LDAP = array(
    'ldap_add',
  	'ldap_delete',
  	'ldap_list',
  	'ldap_read',
  	'ldap_search'
  );



  // File Disclosure
  public static $FILEDISC = array(
    'bzread',
  	'bzflush',
  	'dio_read',
  	'eio_readdir',
  	'fdf_open',
  	'file',
  	'file_get_contents',
  	'finfo_file',
  	'fflush',
  	'fgetc',
  	'fgetcsv',
  	'fgets',
  	'fgetss',
  	'fread',
  	'fpassthru',
  	'fscanf',
  	'ftok',
  	'get_meta_tags',
  	'glob',
  	'gzfile',
  	'gzgetc',
  	'gzgets',
  	'gzgetss',
  	'gzread',
  	'gzpassthru',
  	'highlight_file',
  	'imagecreatefrompng',
  	'imagecreatefromjpg',
  	'imagecreatefromgif',
  	'imagecreatefromgd2',
  	'imagecreatefromgd2part',
  	'imagecreatefromgd',
  	'opendir',
  	'parse_ini_file',
  	'php_strip_whitespace',
  	'readfile',
  	'readgzfile',
  	'readlink',
  	'scandir',
  	'show_source',
  	'simplexml_load_file',
  	'stream_get_contents',
  	'stream_get_line',
  	'xdiff_file_bdiff',
  	'xdiff_file_bpatch',
  	'xdiff_file_diff_binary',
  	'xdiff_file_diff',
  	'xdiff_file_merge3',
  	'xdiff_file_patch_binary',
  	'xdiff_file_patch',
  	'xdiff_file_rabdiff',
  	'yaml_parse_file',
  	'zip_open'
  );

  // File Manipulation
  public static $FILEMANI = array(
    'bzwrite',
  	'chmod',
  	'chgrp',
  	'chown',
  	'copy',
  	'dio_write',
  	'eio_chmod',
  	'eio_chown',
  	'eio_mkdir',
  	'eio_mknod',
  	'eio_rmdir',
  	'eio_write',
  	'eio_unlink',
  	'error_log',
  	'event_buffer_write',
  	'file_put_contents',
  	'fputcsv',
  	'fputs',
  	'fprintf',
  	'ftruncate',
  	'fwrite',
  	'gzwrite',
  	'gzputs',
  	'loadXML',
  	'mkdir',
  	'move_uploaded_file',
  	'posix_mknod',
  	'recode_file',
  	'rename',
  	'rmdir',
  	'shmop_write',
  	'touch',
  	'unlink',
  	'vfprintf',
  	'xdiff_file_bdiff',
  	'xdiff_file_bpatch',
  	'xdiff_file_diff_binary',
  	'xdiff_file_diff',
  	'xdiff_file_merge3',
  	'xdiff_file_patch_binary',
  	'xdiff_file_patch',
  	'xdiff_file_rabdiff',
  	'yaml_emit_file'
  );



}
