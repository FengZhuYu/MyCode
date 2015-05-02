<?php
/**
 *
 * @author mao.yongxiang
 * @since  2015-05-02
 */

namespace Base\Contrller;
use Think\Controller;

class BaseController extends Controller {

    public function __controller() {
        parent::__construct();
    }
}