<?php
/**
 * Created by PhpStorm.
 * User: qkl | QQ:80508567 Wechat:qklandy
 * Date: 2016/1/5 14:32
 */
namespace ecui;

require ECUI_PATH.'base.php';
require ECUI_PATH.'Loader.php';

//ע���Զ�����
Loader::register();

//��̬ע�ᵥ��Ŀ��namespace ����Ŀ�ĸ�Ŀ¼
Loader::addNamespace('app',APP_PATH);

Route::dispather();




