<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 16:54
 */

namespace miserenkov\gearman\exceptions;


use yii\base\Exception;

class ServerConnectionException extends Exception
{
    public function getName()
    {
        return 'ServerConnectionException';
    }
}