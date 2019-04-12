<?php
/**
 * Created by PhpStorm.
 * User: mayunfeng
 * Date: 2019/4/12
 * Time: 15:32
 */

namespace mayunfeng\EasyApi\Behaviors;


use mayunfeng\EasyApi\Events\LogonEvent;
use mayunfeng\EasyApi\Models\UserLogon;
use yii\base\Behavior;
use yii\caching\Cache;

class LoginBehavior extends Behavior
{
    /** @var Cache */
    public $cache;

    public $userIdParam = 'Uid';

    public $tokenParam = 'AToken';

    public $duration = 3600 * 24;

    public function events()
    {
        return [
            UserLogon::EVENT_AFTER_LOGIN => 'afterLogon',
        ];
    }

    // 登录
    public function afterLogon(LogonEvent $event)
    {
        if (\Yii::$app->getSession()->getIsActive()) {
            \Yii::$app->session->set($this->userIdParam, $event->userId);
            \Yii::$app->session->set($this->tokenParam, $event->token);
        }
        $this->cache->set($event->token, $event->userId, $this->duration);
    }

}
