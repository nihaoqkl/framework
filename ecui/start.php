<?php
/**
 * Created by PhpStorm.
 * User: qkl | QQ:80508567 Wechat:qklandy
 * Date: 2016/1/5 14:32
 */
namespace ecui;

require ECUI_PATH.'base.php';
require ECUI_PATH.'Loader.php';

//注册自动载入
Loader::register();

//动态注册单项目的namespace 单项目的根目录
Loader::addNamespace('app',APP_PATH);

Route::dispather();




