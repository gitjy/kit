<?php
//自定义模板引擎
class MySmarty{
	protected $_out = [];

	//向模板中放置变量
	public function assign($key, $value = null) {
		if (is_array($key)) {
			$this->_out = array_merge($key, $this->out);
		} else {
			$this->_out[$key] = $value;
		}
		return $this;
	}

	//加载模板
	public function display($tpl) {
		//读取模板内容
		$info = file_get_contents($tpl);
		//遍历信息，并做替换
		foreach ($this->_out as $k => $v) {
			$info = str_replace('{$'. $k .'}', $v, $info);
		}

		ob_start();	//开启输出缓冲
		echo $info;
		$str = ob_get_contents();

		file_put_contents($tpl . '.tmp', $str);

		ob_end_flush();
	}

}