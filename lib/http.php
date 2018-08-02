<?php

/**
 * HTTP - 公共类库
 *
 * @author Jack.Zhu<25282538@qq.com>
 */
class Http
{
    /**
     * HTTP 请求
     * @param string $url 链接
     * @param array $post 数据
     * @param array $conf 扩展配置
     *              [
     *                  'cache' => 1, // 是否对结果缓存
     *                  'json' => 1, // 是否进行反编译JSON串
     *                  'obj' => 1, // 是否返回CURL对象
     *                  'log' => 1, // 是否记录错误日志
     *              ]
     * @return array|resource
     * ['url'=>'http://xxxx.com/yyy',...,'ok'=>'1','data'=>'']
     */
    static function run($url, $post = array(), $conf = array())
    {
        $ip = Check::ip();
        if ('127.0.0.1' !== $ip) {
            if (!isset($conf[CURLOPT_HTTPHEADER])) $conf[CURLOPT_HTTPHEADER] = array();
            $conf[CURLOPT_HTTPHEADER][] = 'Client-Ip: ' . $ip;
        }
        $fld = '';
        if (false !== strpos($url, '#')) {
            list($url, $fld) = explode('#', $url);
        }
        $uri = $url . ($post ? (false !== strpos($url, '?') ? '&' : '?') . (is_array($post) ? http_build_query($post) : $post) : '');
        if (!isset($conf['ac']) && isset($post['a'], $post['c'])) unset($post['a'], $post['c']);
        $conf = $conf + array('cache' => 1, 'json' => 0, 'obj' => 0, 'log' => 1,);
        $key = $conf['cache'] && ((!$post || ($post && '?' == substr($url, -1))) && !isset($conf[CURLOPT_CUSTOMREQUEST]))
            ? $uri : null;
        if (debug('d')) {
            $key = '';
        }
        if (!isset($conf['fack'])) $conf['fack'] = 0;
        $fun = function () use (&$url, &$post, &$conf, &$fld, &$uri) {
            $s = curl_init();
            $t = microtime(1);
            $o = self::opt($url, $post, $conf);
            curl_setopt_array($s, $o);
            $data = curl_exec($s);
            if ($conf['obj']) {
                return $s;
            }
            $code = curl_getinfo($s, CURLINFO_HTTP_CODE);
            $info['url'] = $uri;
            $info['ok'] = strpos('|200|201|302|301', $code . '') ? '1' : '0';
            $info['data'] = $conf['json'] || 0 === strpos(trim($data), '{') ? json_decode($data, 1) : $data;
            if (!$info['data']) $info['data'] = $data;
            if (!$info['ok'] && $conf['log']) {
                logger('/err', $info['url'], curl_error($s), $info['data']);
                $info = false;
            }
            if (debug('h')) {
                $t = microtime(1) - $t;
                var_dump($t . 's', $o, $uri, $data);
            }
            curl_close($s);
            return $info;
        };
        if ($key) {
            $ttl = isset($conf['ttl']) ? $conf['ttl'] : 3600;
            $del = isset($conf['del']);
            $rc = Cache::run('http');
            if ($del) {
                $rc->hDo('http', $ttl, $key, false);
            }
            $rs = $rc->hDo('http', $ttl, $key);
            if (!$rs) $rs = $rc->hDo('http', $ttl * 2, $key);
            if (!$rs) {
                $rs = $fun();
                if ($rs) {
                    $rc->hDo('http', $ttl, $key, $rs);
                }
            }
        } else {
            $rs = $fun();
        }
        if ($fld && $rs) {
            $rt = Config::get($fld, null, $rs['data']);
            if (null === $rt) {
                if (isset($rc, $ttl)) {
                    $rc->hDo('http', $ttl, $key, false);
                }
                if (isset($rs['data']['code'], $info['data']['msg'])) {
                    Check::err($rs['data']['code'], $rs['data']['msg'], array($rs['url']));
                } else {
                    Check::err(L_BASE_FAILURE, $rs);
                }
            }
            $rs = $rt;
        }
        return $rs;
    }

    /**
     * 返回 HTTP 请求选项
     * @param string $url 链接
     * @param array $post 数据
     * @param array $conf 扩展配置
     * @return array
     */
    static function opt($url, &$post = array(), $conf = array())
    {
        $opt = array(
            CURLOPT_REFERER => $url,
            CURLOPT_USERAGENT => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15',
            CURLOPT_COOKIE => isset($_SERVER['HTTP_COOKIE']) ? $_SERVER['HTTP_COOKIE'] : null,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLINFO_CONNECT_TIME => 30,
            CURLOPT_TIMEOUT => 10,
            // 在那个 domain 没有 IPv6 的情况下，会等待 IPv6 解析失败 timeout 之后才按以前的正常流程去找 IPv4。
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        );
        if (0 === strpos($url, 'https://')) {
            $opt[CURLOPT_SSL_VERIFYPEER] = false;
            $opt[CURLOPT_SSL_VERIFYHOST] = false;
        }
        foreach ($conf as $k => $v) {
            if (is_int($k)) {
                $opt[$k] = $v;
            }
        }
        if (isset($_ENV['c']['http_param'])) {
            $host = parse_url($url, PHP_URL_HOST);
            if (isset($_ENV['c']['http_param'][$host])) {
                $param = $_ENV['c']['http_param'][$host];
                if (is_callable($param)) $param = $param($post);
                $post += $param;
            }
        }
        if ($post) {
            if ('?' === substr($url, -1) && !isset($conf[CURLOPT_POST])) {
                $url .= is_array($post) ? http_build_query($post) : $post;
            } else {
                if (is_array($post)) {
                    foreach ($post as $k => $v) {
                        if (is_array($v)) {
                            $v = urldecode(http_build_query(array($k => $v)));
                            $v = explode('&', $v);
                            foreach ($v as $r) {
                                $t = explode('=', $r . '=');
                                $post[$t[0]] = $t[1];
                            }
                            unset($post[$k]);
                        } elseif ($v && is_string($v) && '@' == $v[0]) {
                            $post[$k] = curl_file_create(substr($v, 1));
                        }
                    }
                }
                if (!isset($opt[CURLOPT_CUSTOMREQUEST])) $opt[CURLOPT_POST] = true;
                $opt[CURLOPT_POSTFIELDS] = $post;
            }
        }
        $opt[CURLOPT_URL] = $url;
        return $opt;
    }

    /**
     * 多线程批量执行
     * @param array $runs 执行 URL
     *                          array(
     *                          'url_1',
     *                          array(
     *                          'url' => 'url_2',
     *                          'data' => '&key1=val1&key2=val2',
     *                          ),
     *                          )
     * @param array $conf 配置
     *                          CURLOPT_TIMEOUT => 1,
     *                          CURLOPT_COOKIE => "j=j;k=k",
     *                          CURLOPT_COOKIEFILE => "xx.com",
     *                          CURLOPT_HTTPAUTH =>
     *                          CURLAUTH_ANY/CURLAUTH_ANYSAFE, CURLOPT_USERPWD
     *                          => "username:password",
     *                          'per' => 500, // 每批数量
     *                          'sleep' => 5, // 每批执行完停顿几秒
     *                          'is_show' => 1, // 是否打印结果
     * @return array
     */
    static function mRun($runs, $conf = null)
    {
        function_exists('ignore_user_abort') && ignore_user_abort(true);
        set_time_limit(0);
        $cnt = count($runs);
        $res = array();
        if (1000 < $cnt || isset ($conf['per'])) {
            $per = isset ($conf['per']) ? $conf['per'] : 500;
            $sleep = isset ($conf['sleep']) ? $conf['sleep'] : 5;
            $offset = 0;
            $cnt = count($runs);
            while ($offset < $cnt) {
                $url = array_slice($runs, $offset, $per);
                $offset += $per;
                if ($url) {
                    $res2 = self::mRun($url, $conf);
                    $res = array_merge($res, $res2);
                    sleep($sleep);
                }
            }
            return $res;
        }
        $mh = curl_multi_init();
        $conn = array();
        foreach ($runs as $i => $run) {
            $url = is_string($run) ? $run : $run['url'];
            $data = isset ($run['data']) ? $run['data'] : null;
            $opt = self::opt($url, $data, $conf);
            $conn[$i] = curl_init();
            curl_setopt_array($conn[$i], $opt);
            curl_multi_add_handle($mh, $conn[$i]);
        }
        do {
            $status = curl_multi_exec($mh, $active);
        } while ($status === CURLM_CALL_MULTI_PERFORM || $active);
        $isShow = isset ($conf['is_show']) && $conf['is_show'];
        foreach ($runs as $i => $url) {
            $res[$i] = curl_multi_getcontent($conn[$i]);
            if ($isShow) {
                echo $res[$i] . "\n";
                unset ($res[$i]);
            }
            curl_close($conn[$i]);
        }
        return $res;
    }

    /**
     * 返回完整URL
     * @param string $url 链接
     * @param array $params 参数 ~sort 参数自动排序 ~path 返回无域名的路径
     * @return string
     */
    static function url($url = null, $params = array())
    {
        $scheme = self::https();
        if (!isset($_ENV['_FullUrl'])) {
            $_ENV['_FullUrl'] = $scheme . $_SERVER["HTTP_HOST"]
                . (isset($_SERVER["HTTP_PORT"]) && '80' != $_SERVER["HTTP_HOST"] ? ':' . $_SERVER["HTTP_HOST"] : '')
                . '/';
        }
        if (!isset($url)) {
            $url = $_SERVER['REQUEST_URI'];
        }
        $isPath = 0;
        if ($params) {
            if (isset($params['_debug']) && is_array($params['_debug'])) {
                $params['_debug'] = join('', $params['_debug']);
            }
            $isCurr = !isset($_ENV['_fixed']) && $url == $_SERVER['REQUEST_URI'];
            $exp = explode('?', $url);
            if (isset($exp[1])) {
                $url = $exp[0];
                parse_str($exp[1], $cgi);
                $params = array_merge($cgi, $params);
            }
//            if ($isCurr) {
//                $uri = [];
//                foreach ($_ENV['_GP'] as $k => $v) {
//                    if (isset($params[$k])) {
//                        $v = $params[$k];
//                        unset($params[$k]);
//                    } else {
//                        $v = isset($_REQUEST[$k]) ? $_REQUEST[$k] : null;
//                        if ((isset($_ENV['_def'][$k . '.force']) && $v == $_ENV['_def'][$k . '.force'])
//                            || (isset($_ENV['_def'][$k . '.rule']) && $v == $_ENV['_def'][$k . '.rule'])
//                            || (isset($_ENV['_def'][$k]) && $v == $_ENV['_def'][$k])) {
//                            $v = null;
//                        }
//                    }
//                    $uri[] = self::urlVal($v);
//                }
//                if ($uri) {
//                    $url = $_ENV['_web'] . str_replace(array('%25s', '-index'), array('%s', ''), rtrim(join('-', $uri), '-'));
//                }
//                if ($_ENV['_ext'] && 'html' != $_ENV['_ext']) {
//                    $url .= '.' . $_ENV['_ext'];
//                }
//            }
            if (isset($params['~sort'])) {
                unset($params['~sort']);
                ksort($params);
            }
            if (isset($params['~path'])) {
                unset($params['~path']);
                $isPath = 1;
            }
            if ($params) {
                $url .= (false !== strpos($url, '?') ? '&' : '?') . http_build_query($params);
            }
        }
        if (false === ($pos = strpos($url, '://'))) {
            $url = $_ENV['_FullUrl'] . ltrim($url, '/');
        } else {
            $url = $scheme . substr($url, $pos + 3);
        }
        if ($isPath) {
            $url = preg_replace('~.*://[^/]+~s', '', $url);
        }
        return $url;
    }

    /**
     * 格式化URL参数值
     * @param array|string $v 参数值
     * @return string
     */
    static function urlVal($v)
    {
        if (is_array($v)) {
            $v = json_encode($v, 288);
            if (!str_replace(array('"', '[', ']', ','), '', $v)) {
                $v = '';
            }
        }
        $v = strtr($v, array('-' => '__', '.' => '**', '%' => '%25', '"' => '%22', "'" => '%27'));
        return $v;
    }

    /**
     * 根据当前地址返回HTTP/HTTPS协议头
     * @param string $url URL 为空返回当前协议头
     * @param bool $force 强制转
     * @return string https:// http://
     */
    static function https($url = '', $force = false)
    {
        if (!isset($_ENV['scheme'])) {
            $_ENV['scheme'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        }
        if (!$url) {
            return $_ENV['scheme'];
        }
        return str_replace('http://', $force ? 'https://' : $_ENV['scheme'], $url);
    }
}
