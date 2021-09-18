<?php

class MySmarty {
	protected $_out = [];

	function assign($key, $value = null) {
		if (is_array($key)) {
			$this->_out = array_merge($key, $this->_out);
		} else {
			$this->_out[$key] = $value;
		}
	}

	function display($tpl)
	{
		$info = file_get_contents($tpl);

		foreach ($this->_out as $k => $v) {
			$info = str_replace('{$' . $k .'}', $v, $info);
		}

		ob_start();
		echo $info;
		//$str = ob_get_contents();
		file_put_contents($tpl . '.tmp', $info);
		ob_end_flush();
	}
}