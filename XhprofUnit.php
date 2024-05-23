<?php
/**
 * 单元测试
 *
 * @author Jack.Zhu<25282538@qq.com>
 */
class XhprofUnit
{
    /**
     * 分层PHP性能分析工具
     * GOOGLE查找 php7 插件
     */
    static function xhprof()
    {
        xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY, array());
        register_shutdown_function(function () use($XHPROF_ROOT) {
            //让数据收集程序在后台运行
             if (function_exists('fastcgi_finish_request')) {
                 fastcgi_finish_request();
             }
            $xdata = xhprof_disable();
            $XHPROF_ROOT = __DIR__ . '/xhprof/';
            include_once  $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_lib.php';
            include_once  $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_runs.php';
            $xruns = new XHprofRuns_Default();
            $name = preg_replace(array("/(\?.*)/", "/[^\w]+/"), array('', '_'), $_SERVER['REQUEST_URI']);
            if (!$name)
                $name = 'index';
            $runId = $xruns->save_run($xdata, $name);
            echo $runId;
        });
    }

    /**
     * 分层PHP性能分析工具 基于mysql
     * GOOGLE查找 php7
     */
    static function xhprofdb()
    {
        xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY, array());
        register_shutdown_function(function () {
            //让数据收集程序在后台运行
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }
            $xdata = xhprof_disable();
            $XHPROF_ROOT = __DIR__ . '/xhprofdb';
            include_once $XHPROF_ROOT . "/xhprof_lib/config.php";
            include_once  $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_lib.php';
            include_once  $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_runs.php';
            $_xhprof['servername'] = 't01';
            $GLOBALS['_xhprof'] = $_xhprof;	//定义为全局可用
            $xruns = new XHprofRuns_Default();
            $name = preg_replace(array("/(\?.*)/", "/[^\w]+/"), array('', '_'), $_SERVER['REQUEST_URI']);
            if (!$name)
                $name = 'index';
            $xruns->save_run($xdata, $name);
        });
    }
}
