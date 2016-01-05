<?php
/**
 * Created by PhpStorm.
 * User: qkl | QQ:80508567 Wechat:qklandy
 * Date: 2016/1/5 10:28
 */
ini_set('display_errors',1);
error_reporting(E_ALL);

if(version_compare(PHP_VERSION,'5.4.0','<')) die('你的PHP环境太低了，最低要求PHP5.4+');

define('DS',DIRECTORY_SEPARATOR);
define('ECUI_PATH','../ecui/');
define('APP_NAME','app');
define('APP_PATH',dirname(__FILE__).DS);
define('APP_ENTER',substr(strrchr(__FILE__,DS),1));



define('APP_NAMESPACE',APP_PATH);

define('URL_MODE',2);

require '../ecui/start.php';

