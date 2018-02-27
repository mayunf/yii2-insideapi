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

    public $debug = false;

    public $token;

    public $access_key;

    public $config;

    /** @var  Application */
    private static $_app;

    /**
     * single instance of InsideAPI\Foundation\Application
     */
    public function getApp()
    {
        if (!self::$_app instanceof Application) {
            self::$_app = new Application(array_merge($this->config,[
                'debug' => $this->debug,
                'token' => $this->token,
                'access_key' => $this->access_key,
            ]));
        }

        return self::$_app;
    }

    public function login($user)
    {
        Yii::$app->session->set('Accesstoken',$user['Accesstoken']);
        Yii::$app->session->set('SessionID',$user['SessionID']);
        Yii::$app->session->set('UserId',$user['UserId']);
    }

    public function getUserId()
    {
        return Yii::$app->session->get('UserId');
    }

    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (\Exception $exception) {
            if ($this->getApp()->$name) {
                return $this->app->$name;
            } else {
                throw $exception->getPrevious();
            }
        }
    }
}