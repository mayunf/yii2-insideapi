<?php
/**
 * Created by PhpStorm.
 * User: mayunfeng
 * Date: 2019/4/12
 * Time: 16:55.
 */

namespace mayunfeng\EasyApi\Excepts;

use yii\base\Exception;

class UnInstanceExcept extends Exception
{
    public function getName()
    {
        return 'UnInstanceExcept';
    }
}
