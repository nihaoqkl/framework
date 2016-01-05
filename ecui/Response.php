<?php
/**
 * Created by PhpStorm.
 * User: qkl | QQ:80508567 Wechat:qklandy
 * Date: 2016/1/5 16:33
 */
namespace ecui;


class Response
{
	// ������ݵ�ת������
	protected static $tramsform = null;
	// ������ݵ�����
	protected static $type = '';
	// �������
	protected static $data = '';
	// �Ƿ�exit
	protected static $isExit = false;
	/**
	 * �������ݵ��ͻ���
	 * @access protected
	 * @param mixed $data Ҫ���ص�����
	 * @param String $type �������ݸ�ʽ
	 * @param bool $return �Ƿ񷵻�����
	 * @return void
	 */
	public static function send($data = '', $type = '', $return = false)
	{
		$type = strtolower($type ?: self::$type);
		$headers = [
			'json'   => 'application/json',
			'xml'    => 'text/xml',
			'html'   => 'text/html',
			'jsonp'  => 'application/javascript',
			'script' => 'application/javascript',
			'text'   => 'text/plain',
		];
		if (!headers_sent() && isset($headers[$type])) {
			header('Content-Type:' . $headers[$type] . '; charset=utf-8');
		}
		$data = $data ?: self::$data;
		if (is_callable(self::$tramsform)) {
			$data = call_user_func_array(self::$tramsform, [$data]);
		} else {
			switch ($type) {
				case 'json':
					// ����JSON���ݸ�ʽ���ͻ��� ����״̬��Ϣ
					$data = json_encode($data, JSON_UNESCAPED_UNICODE);
					break;
				case 'jsonp':
					// ����JSON���ݸ�ʽ���ͻ��� ����״̬��Ϣ
					$handler = !empty($_GET[Config::get('var_jsonp_handler')]) ? $_GET[Config::get('var_jsonp_handler')] : Config::get('default_jsonp_handler');
					$data    = $handler . '(' . json_encode($data, JSON_UNESCAPED_UNICODE) . ');';
					break;
				case '':
					// ����Ϊ�ղ�������
					break;
				default:
					// ������չ�������ظ�ʽ����
					APP_HOOK && Hook::listen('return_data', $data);
			}
		}
		if ($return) {
			return $data;
		}
		echo $data;
		self::isExit() && exit();
	}
	/**
	 * ת�����������������
	 * @access public
	 * @param mixed $callback ���õ�ת������
	 * @return void
	 */
	public static function tramsform($callback)
	{
		self::$tramsform = $callback;
	}
	/**
	 * �����������
	 * @access public
	 * @param string $type ������ݵĸ�ʽ����
	 * @return void
	 */
	public static function type($type = null)
	{
		if (is_null($type)) {
			return self::$type ?: Config::get('default_return_type');
		}
		self::$type = $type;
	}
	/**
	 * �����������
	 * @access public
	 * @param mixed $data �������
	 * @return void
	 */
	public static function data($data)
	{
		self::$data = $data;
	}
	/**
	 * ����Ƿ�exit����
	 * @access public
	 * @param bool $exit �Ƿ��˳�
	 * @return void
	 */
	public static function isExit($exit = null)
	{
		if (is_null($exit)) {
			return self::$isExit;
		}
		self::$isExit = (boolean) $exit;
	}
	/**
	 * ���ط�װ���API���ݵ��ͻ���
	 * @access public
	 * @param mixed $data Ҫ���ص�����
	 * @param integer $code ���ص�code
	 * @param mixed $msg ��ʾ��Ϣ
	 * @param string $type �������ݸ�ʽ
	 * @return void
	 */
	public static function result($data, $code = 0, $msg = '', $type = '')
	{
		$result = [
			'code' => $code,
			'msg'  => $msg,
			'time' => NOW_TIME,
			'data' => $data,
		];
		if ($type) {
			self::type($type);
		}
		return $result;
	}
	/**
	 * �����ɹ���ת�Ŀ�ݷ���
	 * @access public
	 * @param mixed $msg ��ʾ��Ϣ
	 * @param mixed $data ���ص�����
	 * @param mixed $url ��ת��URL��ַ
	 * @param mixed $wait ��ת�ȴ�ʱ��
	 * @return void
	 */
	public static function success($msg = '', $data = '', $url = '', $wait = 3)
	{
		$code = 1;
		if (is_numeric($msg)) {
			$code = $msg;
			$msg  = '';
		}
		$result = [
			'code' => $code,
			'msg'  => $msg,
			'data' => $data,
			'url'  => $url ?: $_SERVER["HTTP_REFERER"],
			'wait' => $wait,
		];
		$type = IS_AJAX ? Config::get('default_ajax_return') : Config::get('default_return_type');
		if ('html' == $type) {
			$result = \think\View::instance()->fetch(Config::get('dispatch_jump_tmpl'), $result);
		}
		self::type($type);
		return $result;
	}
	/**
	 * ����������ת�Ŀ�ݷ���
	 * @access public
	 * @param mixed $msg ��ʾ��Ϣ
	 * @param mixed $data ���ص�����
	 * @param mixed $url ��ת��URL��ַ
	 * @param mixed $wait ��ת�ȴ�ʱ��
	 * @return void
	 */
	public static function error($msg = '', $data = '', $url = '', $wait = 3)
	{
		$code = 0;
		if (is_numeric($msg)) {
			$code = $msg;
			$msg  = '';
		}
		$result = [
			'code' => $code,
			'msg'  => $msg,
			'data' => $data,
			'url'  => $url ?: 'javascript:history.back(-1);',
			'wait' => $wait,
		];
		$type = IS_AJAX ? Config::get('default_ajax_return') : Config::get('default_return_type');
		if ('html' == $type) {
			$result = \think\View::instance()->fetch(Config::get('dispatch_jump_tmpl'), $result);
		}
		self::type($type);
		return $result;
	}
	/**
	 * URL�ض���
	 * @access protected
	 * @param string $url ��ת��URL���ʽ
	 * @param array|int $params ����URL������http code
	 * @return void
	 */
	public static function redirect($url, $params = [])
	{
		$http_response_code = 301;
		if (in_array($params, [301, 302])) {
			$http_response_code = $params;
			$params             = [];
		}
		$url = preg_match('/^(https?:|\/)/', $url) ? $url : Url::build($url, $params);
		header('Location: ' . $url, true, $http_response_code);
	}
	/**
	 * ������Ӧͷ
	 * @access protected
	 * @param string $name ������
	 * @param string $value ����ֵ
	 * @return void
	 */
	public static function header($name, $value)
	{
		header($name . ':' . $value);
	}
	// ����Http״̬��Ϣ
	public static function sendHttpStatus($status)
	{
		static $_status = [
			// Informational 1xx
			100 => 'Continue',
			101 => 'Switching Protocols',
			// Success 2xx
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			// Redirection 3xx
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Moved Temporarily ', // 1.1
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			// 306 is deprecated but reserved
			307 => 'Temporary Redirect',
			// Client Error 4xx
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			// Server Error 5xx
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			509 => 'Bandwidth Limit Exceeded',
		];
		if (isset($_status[$status])) {
			header('HTTP/1.1 ' . $status . ' ' . $_status[$status]);
			// ȷ��FastCGIģʽ������
			header('Status:' . $status . ' ' . $_status[$status]);
		}
	}
}