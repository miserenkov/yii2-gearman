<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 17:02
 */

namespace miserenkov\gearman;


use yii\base\Object;

class JobWorkload extends Object implements \Serializable
{
    protected $params = [];

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
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