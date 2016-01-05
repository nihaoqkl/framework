<?php
/**
 * Created by PhpStorm.
 * User: qkl | QQ:80508567 Wechat:qklandy
 * Date: 2016/1/5 16:10
 */

namespace ecui;

class View {

	use traits\Instance;

	protected $templatePath;

	public function __construct($templatePath = "") {
		$this->templatePath = $templatePath;
	}


	public function show() {
		echo 'show';
	}

	public function render(ResponseInterface $response, $template, array $data = [])
	{
		if (isset($data['template'])) {
			throw new \InvalidArgumentException("Duplicate template key found");
		}
		if (!is_file($this->templatePath . $template)) {
			throw new \RuntimeException("View cannot render `$template` because the template does not exist");
		}
		$render = function ($template, $data) {
			extract($data);
			include $template;
		};
		ob_start();
		$render($this->templatePath . $template, $data);
		$output = ob_get_clean();
		$response->getBody()->write($output);

		return $response;
	}
}