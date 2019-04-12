<?php
/**
 * Created by PhpStorm.
 * User: mayunfeng
 * Date: 2018/2/24
 * Time: 14:24
 */

namespace mayunfeng\EasyApi;

use Yii;
use InsideAPI\Foundation\Application;
use yii\base\Component;

class EasyApi extends Component
{
    /**
     * @var Application
     */
    protected static $instance;

    public $config;

    public $userParam = 'UserId';

    public $tokenParam = 'AToken';

    /**
     * @param int $userId
     * @return Application;
     */
    public function api($userId = 0)
    {
        if (!self::$instance instanceof Application) {
            $config = array_merge(['user_id' => $userId], $this->config);
            self::$instance = new Application($config);
        }
        return self::$instance;
    }

    public function login($data)
    {
        \Yii::$app->session->set($this->userParam, $data['Uid']);
        \Yii::$app->session->set($this->tokenParam, $data['AToken']);
        $redis = \Yii::$app->redis;
        $redis->set($data['AToken'], $data['Uid']);
        $redis->expire($data['AToken'], 3600 * 2);
    }

}
