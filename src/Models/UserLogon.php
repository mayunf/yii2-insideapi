<?php
/**
 * Created by PhpStorm.
 * User: mayunfeng
 * Date: 2019/4/12
 * Time: 14:23.
 */

namespace mayunfeng\EasyApi\Models;

use InsideAPI\Enum\EProductType;
use mayunfeng\EasyApi\EasyApi;
use mayunfeng\EasyApi\Events\LogonEvent;
use mayunfeng\EasyApi\Excepts\UnInstanceExcept;

class UserLogon extends \yii\base\Model
{
    const EVENT_AFTER_LOGIN = 'afterLogin';

    public $phone; //手机号登录

    public $password; //用户密码

    public $type; // 产品类型

    /** @var EasyApi */
    private $insideApi;

    /**
     * @return EasyApi
     */
    public function getInsideApi()
    {
        if ($this->insideApi) {
            return $this->insideApi;
        }

        return \Yii::$app->insideapi;
    }

    /**
     * @param EasyApi $insideApi
     *
     * @throws UnInstanceExcept
     */
    public function setInsideApi($insideApi)
    {
        if ($insideApi instanceof EasyApi) {
            $this->insideApi = $insideApi;
        }

        throw new UnInstanceExcept('');
    }

    public function behaviors()
    {
        return [
            [
                'class'    => 'mayunfeng\EasyApi\Behaviors\LogonBehavior',
                'cache'    => \Yii::$app->cache,
                'duration' => 3600 * 24,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['password', 'phone'], 'required'],

            [['phone', 'password'], 'string'],

            [['type'], 'default', 'value' => EProductType::XLTG_Web],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone'    => '手机号',
            'password' => '密码',
            'type'     => '产品类型',
        ];
    }

    public function logon()
    {
        if ($this->validate()) {
            try {
                $user = $this->getInsideApi()->api()->access_token->getToken($this->phone, $this->password, $this->type);
                $this->trigger(self::EVENT_AFTER_LOGIN, new LogonEvent([
                    'userId' => $user['Uid'],
                    'token'  => $user['AToken'],
                ]));

                return \Yii::$app->getUser()->login(User::findIdentity($user['Uid']));
            } catch (\Exception $exception) {
                $this->addError($this->phone, '用户名或密码错误');

                return false;
            }
        } else {
            return false;
        }
    }
}
