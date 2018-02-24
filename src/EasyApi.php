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

    /** @var  Application */
    private static $_app;

    /**
     * single instance of InsideAPI\Foundation\Application
     */
    public function getApp()
    {
        if (!self::$_app instanceof Application) {
            self::$_app = new Application(Yii::$app->params['insideapi']);
        }

        return self::$_app;
    }

    public function login($user)
    {
//        $_SESSION['Accesstoken'] = $user['Accesstoken'];// 设置访问Token
//        $_SESSION['SessionID'] = $user['SessionID'];// 设置访问SessionID
//        $_SESSION['UserId'] = $user['UserId'];// 设置当前登录用户的UID

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