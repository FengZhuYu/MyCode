<?php
/**
 * 测试类
 * @author mao.yongxiang
 * @since  2015-05-14
 */

class myTest {
    private $host = 'localhost';
    private $user = 'root';
    private $pwd = '123456';

    public function __controller() {
        $this->getLink();
    }

    /**
     * 连接数据库
     */
    private function getLink() {
        $conn = mysql_connect($this->host, $this->user, $this->pwd);
        if(!$conn) {
            die('数据库连接失败!');
        }
        return $conn;
    }
}

$test = new myTest();
echo '<pre>';
var_dump($test);

