<?php
class View
{
    /**
     * json输出
     * @param array $arr 数组
     * @return array
     */
    static function json($arr)
    {
        $str = json_encode($arr, 256);
        return array($str, 'application/json');
    }

    static function display($data, $format = 'json', $tpl = '')
    {
      method_exists('View', $format) && $out = View::$format($data);
      headers_sent() || header('Content-type:' . $out[1] . ';charset=UTF-8;');
      echo $out[0];
    }
}
