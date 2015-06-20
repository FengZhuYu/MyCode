<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {

    public function indexAction(){
        $this->display();
    }

    public function testAction() {
//
//        $memory = memory_get_usage();
//        $memory = $memory / 1024 / 1024;
//        var_dump($memory);
        $time = microtime();
        echo $time;
    }
}