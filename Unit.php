<?php
/**
 * 单元测试
 *
 * @author Jack.Zhu<25282538@qq.com>
 */
class Unit
{
    /**
     * 分层PHP性能分析工具
     * GOOGLE查找 php7 插件
     */
    static function xhprof()
    {
    	$XHPROF_ROOT = __DIR__ . '/xhprof/';
        xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY, array());
        register_shutdown_function(function () use ($XHPROF_ROOT)  {
            $xdata = xhprof_disable();
            include_once  $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_lib.php';
            include_once  $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_runs.php';
            $xruns = new XHprofRuns_Default();
            $name = preg_replace(array("/(\?.*)/", "/[^\w]+/"), array('', '_'), $_SERVER['REQUEST_URI']);
            if (!$name)
                $name = 'index';
            $xruns->save_run($xdata, $name);
        });
    }

    /**
     * 分层PHP性能分析工具 基于mysql
     * GOOGLE查找 php7
     */
    static function xhprofdb()
    {
    	$XHPROF_ROOT = __DIR__ . '/xhprofdb';
        xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY, array());
        register_shutdown_function(function () use ($XHPROF_ROOT) {
            $xdata = xhprof_disable();
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
