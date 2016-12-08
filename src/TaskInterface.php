<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 17:04
 */

namespace miserenkov\gearman;


interface TaskInterface
{
    /**
     * @return string
     */
    public function getName();
    /**
     * @param \GearmanTask|null $task
     * @return mixed
     */
    public function execute(\GearmanTask $task = null);
}