<?php
/**
 * Created by PhpStorm.
 * User: qkl | QQ:80508567 Wechat:qklandy
 * Date: 2016/1/5 11:00
 */

//  版本信息
const ECUI_VERSION     =   '1.0.0';

// 类文件后缀
const EXT               =   '.php';

//URL模式
const URL_NORMAL        =   1;  //普通模式
const URL_PATHINFO      =   2;  //PATHINFO模式
const URL_REWRITE       =   3;  //REWRITE模式


if(version_compare(PHP_VERSION,'5.4.0','<')) {
	ini_set('magic_quotes_runtime',0);
	define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc()? true : false);
}else{
	define('MAGIC_QUOTES_GPC',false);
}
//define('MAGIC_QUOTES_GPC',false);

// 系统常量
defined('DS') or define('DS',DIRECTORY_SEPARATOR);

defined('ECUI_PATH') or define('ECUI_PATH', dirname(__FILE__).DS);
define('CORE_PATH', ECUI_PATH.'core'.DS);

defined('VENDOR_PATH') or define('VENDOR_PATH', ECUI_PATH.'vendor'.DS);

// 环境常量
define('IS_CLI',PHP_SAPI=='cli'? 1   :   0);
define('IS_CGI',(0 === strpos(PHP_SAPI,'cgi') || false !== strpos(PHP_SAPI,'fcgi')) ? 1 : 0 );
define('IS_WIN',strstr(PHP_OS, 'WIN') ? 1 : 0 );
define('NEW_LINE',IS_CLI?PHP_EOL:'<br />');

define('NOW_TIME', $_SERVER['REQUEST_TIME_FLOAT']);