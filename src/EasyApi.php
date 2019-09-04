<?php
/**
 * Created by PhpStorm.
 * User: mayunfeng
 * Date: 2018/2/24
 * Time: 14:24.
 */

namespace mayunfeng\EasyApi;

use InsideAPI\Foundation\Application;
use yii\base\Component;

class EasyApi extends Component
{
    /**
     * @var Application
     */
    protected static $instance;

    public $config;

    public $userParam = 'Uid';

    public $tokenParam = 'AToken';

    /**
     * @param int $userId
     *
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
}
