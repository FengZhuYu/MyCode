<?php
/**
 *
 * @author mao.yongxiang
 * @since  2015-06-06
 */
$url = 'http://www.konka-heizuan.cn';

$content = file_get_contents($url);
echo '<pre>';
var_dump($content);