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