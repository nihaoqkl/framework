<?php
/**
 * Created by PhpStorm.
 * User: qkl | QQ:80508567 Wechat:qklandy
 * Date: 2016/1/5 10:21
 */

namespace ecui;


class Route {

	protected static $maps=[];

	protected $patternMatchers = [
		'/{(.+?):number}/'        => '{$1:[0-9]+}',
		'/{(.+?):word}/'          => '{$1:[a-zA-Z]+}',
		'/{(.+?):alphanum_dash}/' => '{$1:[a-zA-Z0-9-_]+}'
	];

	public static function dispather(){

		if(URL_MODE==URL_NORMAL || strpos($_SERVER['REQUEST_URI'],APP_ENTER)!==false) { //普通模式 自动检测 不一定要开启URL_MODE
			$controller=$_GET['c'];
			$action=$_GET['a'];
		} else if(URL_MODE==URL_PATHINFO) {  //pathinfo模式 手动配置 必须开启URL_MODE
			$uri = explode('/',ltrim($_SERVER['REQUEST_URI'],'/'));
			$controller=$uri[1];
			$action=$uri[2];
		}

		if(file_exists(APP_PATH.'ctl'.DS.$controller.EXT)){

			$ctl=new \app\ctl\index();

			//自动调用 也可以用反射机制等
			//todo 这里需要传入参数 来自get post等
			call_user_func_array([$ctl,$action],[]);
		} else {
			throw new Exception(APP_PATH.'ctl'.DS.$controller.EXT.' 类不存在哦');
		}

	}

	public static function get($match,$callback){

	}


	public static function post($match,$callback){

	}


	public static function put($match,$callback){

	}


	private static function getMethod(){
		return $_SERVER['REQUEST_METHOD'];
	}


	private static function parse_url(){
		//解析URL路径，匹配到Contorller或直接处理
		return $_SERVER['REQUEST_URI'];
	}

	/**
	 * 替换route
	 * @param $route
	 * @return mixed
	 */
	protected function parseRouteString($route) {
		return preg_replace(array_keys($this->patternMatchers), array_values($this->patternMatchers), $route);
	}



}