<?php
class Check {
   /**
     * 检查是否不包含脏字
     * @param string $uname $str
     * @return bool
     */
    static function word($str)
    {
        $bad = file_get_contents('./inefficient.txt');
        $is = mb_eregi($bad, $str, $out);
        var_dump($out);
        return $is ? false : true;
    }

}