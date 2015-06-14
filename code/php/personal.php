 <?php
 /**
     * 个性装扮配置信息
     * @param $momoid 登录用户的momoid
     * @param bool $isDev true为内网测试，false正式上线
     * @return array
     */
    public function getUserSettingInfo($momoid, $isDev = true){
        $receiving = $this->ctx->giftshop->provider_moa_order->waitReceived($momoid);
        if ($receiving > 0) {
            $url = 'http://m.immomo.com/inc/mall/my/myGiftCenter?trec=home';
            $action = '[礼物商城|url|' . $this->ctx->helper->auth->passport($url) . ']';
        } else {
            $url = 'http://m.immomo.com/inc/mall/gift/home';
            $action = '[礼物商城|url|' . $this->ctx->helper->auth->passport($url) . ']';
        }
        $this->model['giftshop']['action'] = $action;

        $online_key = $this->ctx->personal->provider_redis_personal->getOnlineKey();
        $remainder = $momoid % 10;
        $funName = $isDev ? 'getAllDevConfig' : 'getAllOnlineConfig';
        if('getAllOnlineConfig' == $funName){
            $json = $this->ctx->helper->cache->get($online_key);
            if($json){
                $config_list = json_decode($json, true);
            }else{
                $config_list = $this->ctx->personal->provider_redis_personal->{$funName}();
                $this->ctx->helper->cache->set($online_key, json_encode($config_list), 60);
            }
        }else{
            $config_list = $this->ctx->personal->provider_redis_personal->{$funName}();
        }

        if(!empty($config_list)){
            foreach($config_list as $k=>$v){
                $config_list[$k] = json_decode($v,true);
            }
        }

        $tmp = array();
        foreach($config_list as $k => $v){
            $key = substr($k,0,-10);
            if(!empty($v['gray_list']) && !in_array($momoid,$v['gray_list'])){
                continue;
            }
            if(!empty($v['ids']) && !in_array('', $v['ids']) && !in_array($remainder, $v['ids'])) {
                continue;
            }
            if(!isset($tmp[$key]) || $tmp[$key]['start_time'] < $v['start_time']){
                $tmp[$key] = $v;
            }
        }

        $config_list = $tmp;

        $model_config = $this->model;
        foreach ($model_config as $k => $v) {
            $m = $config_list[$k];
            $m['tipsuptime'] = $m['start_time'];
            unset($m['ids']);
            unset($m['start_time']);
            unset($m['end_time']);
            unset($m['gray_list']);
            $model_config[$k] = array_merge($model_config[$k],$m);
            if (!empty($model_config['giftshop']['jump_url'])) {
                $model_config['giftshop']['action'] = '[礼物商城|url|' . $model_config['giftshop']['jump_url'] . ']';
            }
            if (!empty($model_config['decoration']['jump_url'])) {
                $model_config['decoration']['action'] = '[个性装扮|url|' . $model_config['decoration']['jump_url'] . ']';
            }
            unset($model_config[$k]['jump_url']);
        }
        return $model_config;
//
//        $model_config = $this->model;
//        foreach ($config_list as $n => $m) {
//
//            $item = $isDev;
//            if ($isDev && !empty($m['gray_list'])) {
//                $item = in_array($momoid, $m['gray_list']);
//                $gray = in_array($momoid, $m['gray_list']);
//            }
//            foreach ($this->model as $k => $v) {
//                if (stripos($n, $k) === 0 && (empty($m['ids']) || in_array('', $m['ids']) || in_array($remainder, $m['ids'])) && ($item && time() < $m['end_time'] || $gray && (time() > $m['start_time']) && time() < $m['end_time'])) {
//                    if (!empty($model_config[$k]['tipsuptime'])) {
//                        break;
//                    }
//
//                    $m['tipsuptime'] = $m['start_time'];
//                    unset($m['ids']);
//                    unset($m['start_time']);
//                    unset($m['end_time']);
//                    unset($m['gray_list']);
//                    $model_config[$k] = array_merge($model_config[$k],$m);
//                    if (!empty($model_config['giftshop']['jump_url'])) {
//                        $model_config['giftshop']['action'] = '[礼物商城|url|' . $model_config['giftshop']['jump_url'] . ']';
//                    }
//                    if (!empty($model_config['decoration']['jump_url'])) {
//                        $model_config['decoration']['action'] = '[个性装扮|url|' . $model_config['decoration']['jump_url'] . ']';
//                    }
//                    unset($model_config[$k]['jump_url']);
//                    break;
//                }
//            }
//        }
//        return $model_config;
    }
    