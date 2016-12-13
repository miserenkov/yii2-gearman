<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 17:02
 */

namespace miserenkov\gearman;


use yii\base\Object;
use yii\base\UnknownPropertyException;

class JobWorkload extends Object implements \Serializable
{
    private $params = [];

    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        } else {
            throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    public function __isset($name)
    {
        return isset($this->params[$name]);
    }

    public function __unset($name)
    {
        unset($this->params[$name]);
    }

    public function serialize()
    {
        return serialize($this->params);
    }
    public function unserialize($serialized)
    {
        $this->params = unserialize($serialized);
    }
}