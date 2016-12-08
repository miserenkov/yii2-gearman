<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 16:53
 */

namespace miserenkov\gearman\exceptions;


use yii\base\Exception;

class InvalidBootstrapClassException extends Exception
{
    public function getName()
    {
        return 'InvalidBootstrapClassException';
    }
}