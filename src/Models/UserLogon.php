<?php
/**
 * Created by PhpStorm.
 * User: mayunfeng
 * Date: 2019/4/12
 * Time: 14:23.
 */

namespace mayunfeng\EasyApi\Models;

use InsideAPI\Enum\EProductType;
use mayunfeng\EasyApi\Behaviors\LoginBehavior;
use mayunfeng\EasyApi\EasyApi;
use mayunfeng\EasyApi\Events\LogonEvent;
use mayunfeng\EasyApi\Excepts\UnInstanceExcept;
use Yii;
use yii\base\Model;

class UserLogon extends Model
{
    const EVENT_AFTER_LOGIN = 'afterLogin';

    public $phone; //手机号登录

    public $password; //用户密码

    public $type; // 产品类型

    /** @var EasyApi */
    private $easyApi;

    /**
     * @return EasyApi
     */
    public function getEasyApi()
    {
        if ($this->easyApi) {
            return $this->easyApi;
        }

        return Yii::$app->easyApi;
    }

    /**
     * @param EasyApi $easyApi
     *
     * @throws UnInstanceExcept
     */
    public function setEasyApi($easyApi)
    {
        if ($easyApi instanceof EasyApi) {
            $this->easyApi = $easyApi;
        }

        throw new UnInstanceExcept('');
    }

    public function behaviors()
    {
        return [
            [
                'class'    => LoginBehavior::class,
                'cache'    => Yii::$app->cache,
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
                $user = $this->getEasyApi()->api()->access_token->getToken($this->phone, $this->password, $this->type);
                $event = new LogonEvent(['userId' => $user['Uid'], 'token' => $user['AToken']]);
                $this->trigger(self::EVENT_AFTER_LOGIN, $event);

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
