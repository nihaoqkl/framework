<?php
/**
 * Trait 所有类都可以基于此类获得单例方法
 * Created by PhpStorm.
 * User: qkl | QQ:80508567 Wechat:qklandy
 * Date: 2016/1/4 18:12
 */

namespace ecui\traits;

trait Instance {

	protected static $instance = null;
	// 实例化（单例）
	public static function getInstance($options = [])
	{
		if (is_null(self::$instance)) {
			self::$instance = new self($options);
		}
		return self::$instance;
	}

	// 静态调用（魔术方法）
	public static function __callStatic($method, $params)
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		$call = substr($method, 1);
		if (0 === strpos($method, '_') && is_callable([self::$instance, $call])) {
			return call_user_func_array([self::$instance, $call], $params);
		} else {
			throw new core\Exception("not exists method:" . $method);
		}
	}
}