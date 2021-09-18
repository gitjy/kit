<?php
const TMP = __DIR__;
/**
 * 记录日志
 * @return bool|string 成功返回日志路径
 */
function logger()
{
    $a = func_get_args();
    if (!isset($a[0])) { // 如果为空，则检查程序如果出错时记录日志
        $e = error_get_last();
        if (!$e['type'] || false !== strpos($e['file'], '/view/'))
            return false;
        $a[0] = array('code' => 2, 'msg' => explode("\n", $e['message'])[0],);
        $d = $e['file'] . ':' . $e['line'];
        if (!strpos($a[0]['msg'], $d))
            $a[0]['data'] = array($d);
        $_POST = 1;
    }
    if (!$a[0]) {
        return false;
    }
    if (isset($a[0]['code']) && 2 == $a[0]['code']) {
        array_unshift($a, '/err');
    } elseif (!is_string($a[0]) || ('/' != substr($a[0], 0, 1) && false === strpos($a[0], '::'))) {
        $b = debug_backtrace(2, 2);
        array_unshift($a, (isset($b[1]['class']) ? $b[1]['class'] . '::' : '') . ($b[1]['function'] ?? ''));
    }
    defined('SPID') || define('SPID', "\t" . substr(PHP_SAPI, 0, 3) . "\t" . @posix_getpid() . "\t");
    $log = TMP . "$_SERVER[HTTP_HOST]/logs" . ('/' == $a[0][0] ? $a[0] : '/debug') . (isset($_ENV['c']['log_day']) ? date('Ymd') : '') . '.' . substr(PHP_SAPI, 0, 3) . '.log';
    $last = count($a) - 1;
    ($e = '') || is_object($a[$last]) && ($e = print_r($a[$last], 1)) && ($a[$last] = '');
    if ('/err' == $a[0] && 'cli' != PHP_SAPI) $a[0] = Http::url();
    $msg = date('c') . SPID . ('b' === $a[1] ? json_encode(array_slice($a, 0, -1), 256) . "\t" . print_r($a[$last], 1) : json_encode($a, 256)) . ($e ? "\n$e" : "");
    if (true !== $a[1] && !debug('c') && isset($_ENV['c']['log_close']) && (preg_match('/' . $_ENV['c']['log_close'] . '/', $a[0]))) {
        return false;
    }
    if (true === $a[1] || debug('l')) {
        print ('cli' == PHP_SAPI ? '' : '<pre style="white-space: pre-wrap;word-wrap: break-word;">') . str_replace("\\n", "\n", (isset($a[1]) && 'b' === $a[1] ? $msg : mb_substr($msg, 0, 40000)) . ('cli' == PHP_SAPI ? '' : '</pre>') . "\n");
    }
    if (true === $a[1] || strpos($log, 'debug')) {
        return false;
    }
    if (isset($a[1]) && 'nil' == $a[1]) return true;
    if (!is_dir($dir = dirname($log))) mkdir($dir, 0755, true);
    file_put_contents($log, $msg . "\n", FILE_APPEND);
    return is_file($log) ? $log : false;
}
logger(true, 'error', 1000574);
