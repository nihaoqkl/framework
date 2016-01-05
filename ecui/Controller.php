<?php
/**
 * Created by PhpStorm.
 * User: qkl | QQ:80508567 Wechat:qklandy
 * Date: 2016/1/5 10:12
 */

namespace ecui;


class Controller {

	use traits\Jump;

	public function __construct(){
		//todo 初始化一些conrtroller 如view和可以跳转等
		$this->view=View::getInstance();
	}


	public function show(){
		$this->view->show();
	}
}