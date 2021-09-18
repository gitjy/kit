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
        if ($post && is_array($post) && false !== strpos($url, 'uc')) {
            $post['~ip'] = Check::ip();
        }
        $fld = '';
        if (false !== strpos($url, '#')) {
            list($url, $fld) = explode('#', $url);
        }
        $uri = $url . ($post ? (false !== strpos($url, '?') ? '&' : '?') . (is_array($post) ? http_build_query($post) : $post) : '');
        if (!isset($conf['ac']) && isset($post['a'], $post['c'])) unset($post['a'], $post['c']);
        $conf = $conf + array('cache' => 1, 'json' => 0, 'obj' => 0, 'log' => 1,);
        if (!isset($conf['fack'])) $conf['fack'] = 0;
        $fun = function () use (&$url, &$post, &$conf, &$fld, &$uri) {
            $s = curl_init();
            $t = microtime(1);
            $o = self::opt($url, $post, $conf);
            curl_setopt_array($s, $o);
            $data = curl_exec($s);
            //var_dump($data, $o);exit;
            if ($conf['obj']) {
                return $s;
            }
            $code = curl_getinfo($s, CURLINFO_HTTP_CODE);
            $info['url'] = $uri;
            $info['ok'] = strpos('|200|201|302|301', $code . '') ? '1' : '0';
            $info['data'] = $conf['json'] || 0 === strpos(trim($data), '{') ? json_decode($data, 1) : $data;
            if (!$info['data']) $info['data'] = $data;
            if (!$info['ok'] && $conf['log']) {
                //var_dump('/err', $info['url'], curl_error($s), $info['data']);
                //$info = false;

            }
            if (!$info) {
                //var_dump($t . 's', $o, $uri, $data);
            }
            
            curl_close($s);
            return $info;
        };
        $rs = $fun();
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
            CURLOPT_USERAGENT => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
            CURLOPT_COOKIE => isset($_SERVER['HTTP_COOKIE']) ? $_SERVER['HTTP_COOKIE'] : null,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
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

    static function url($url, $params = [])
    {
            if ($params) {
                $url .= (false !== strpos($url, '?') ? '&' : '?') . http_build_query($params);
            }
            return $url;
    }

}
