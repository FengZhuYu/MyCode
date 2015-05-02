<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {

    public function indexAction(){

        $this->display();
    }

    public function testAction() {
        echo date('Y-m-d H:i:s');
    }
}