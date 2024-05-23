<?php
class View
{

   /**
     * 打印
     * @param mixed $msg 数据
     */
    static function dump($msg)
    {
        $str = json_encode($msg, 384);
        return array($str, 'application/json');
    }

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
      if ('jsonp' == $format) {
        $json = json_encode($data, 256);
        $out = array(getCgi('cb', 'cb') . "($json);", 'application/x-javascript');
      } else{
         method_exists('View', $format) && $out = View::$format($data);
      }
      headers_sent() || header('Content-type:' . $out[1] . ';charset=UTF-8;');
      echo $out[0];
    }
}
