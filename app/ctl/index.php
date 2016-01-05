<?php

/**
 * Created by PhpStorm.
 * User: qkl | QQ:80508567 Wechat:qklandy
 * Date: 2016/1/5 15:26
 */
namespace app\ctl;

use ecui\Controller;

class index extends Controller{

	public function index(){
		echo 'app/ctl/index'.NEW_LINE;
		$this->show();
	}
}