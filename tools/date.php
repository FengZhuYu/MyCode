<?php
/**
 *
 * @author mao.yongxiang
 * @since  2015-06-14
 */

$time = $_GET['time'];
$time = $time ? $time : time();

$time = date('Y-m-d H:i:s', $time);
echo $time;