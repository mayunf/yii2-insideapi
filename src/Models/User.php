<?php
/**
 * Created by PhpStorm.
 * User: mayunfeng
 * Date: 2019/4/12
 * Time: 14:21
 */

namespace mayunfeng\EasyApi\Models;


use Yii;
use yii\web\IdentityInterface;

/**
 * Class User
 * @property integer $Uid
 * @property integer $UMainId
 * @property string $LDate
 * @property string $UserName
 * @property string $Company
 * @property string $WebSite
 * @property string $Province
 * @property string $City
 * @property string $County
 * @property string $AddressInfo
 * @property string $Industry
 * @property string $Mobile
 * @property string $BindMobile
 * @property string $Email
 * @property string $BindEmail
 * @property string $QQ
 * @property string $UDate
 * @property string $CDate
 *
 * @package frontend\models
 */
class User implements IdentityInterface
{

    public $Uid = 0;

    protected static $Identity = null;

    public static function findIdentity($id)
    {
        return self::findIdentityFromApi($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findIdentityFromApi($token, false);
    }

    public static function findIdentityFromApi($params, $enableSession = true)
    {
        if (static::$Identity == null) {
            $insideApi = Yii::$app->insideapi;
            if ($enableSession) {
                $userId = Yii::$app->session->get($insideApi->userParam);
            } else {
                $userId = Yii::$app->cache->get($params);
            }
            $user = $insideApi->api($userId)->user->info();
            if ($user['head']['s'] == 0) {
                static::$Identity = Yii::createObject(array_merge([
                    'class' => User::class,
                    'Uid' => $userId
                ], $user['body']));
            } else {
                \Yii::$app->getUser()->logout();
            }
        }
        return static::$Identity;
    }

    public function getId()
    {
        return $this->Uid;
    }

    public function getAuthKey(){}

    public function validateAuthKey($authKey) {}

}
