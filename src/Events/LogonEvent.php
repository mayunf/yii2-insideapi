<?php
/**
 * Created by PhpStorm.
 * User: mayunfeng
 * Date: 2019/4/12
 * Time: 16:04.
 */

namespace mayunfeng\EasyApi\Events;

use yii\base\Event;

class LogonEvent extends Event
{
    public $userId; // 用户 user_id

    public $token; // 用户 token
}
