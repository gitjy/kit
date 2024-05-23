<?php

function xhprof()
{
    xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY, array());
    register_shutdown_function(function () {
    $xdata = xhprof_disable();
    $XHPROF_ROOT = '/Usgers/jiangyong/whole/data/wwwroot/kit/xhprof/';
    include_once $XHPROF_ROOT . 'xhprof_lib/utils/xhprof_lib.php';
    include_once $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_runs.php';
    //让数据收集程序在后台运行
    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
    }
        $xruns = new XHprofRuns_Default();
        $name = preg_replace(array("/(\?.*)/", "/[^\w]+/"), array('', '_'), $_SERVER['REQUEST_URI']);
        if (!$name)
            $name = 'index';
        $xruns->save_run($xdata, $name);
    });
}