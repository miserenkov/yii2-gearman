<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 17:01
 */

namespace miserenkov\gearman;


interface JobInterface
{
    /**
     * @return string
     */
    public function getName();
    /**
     * @param \GearmanJob|null $job
     * @return mixed
     */
    public function execute(\GearmanJob $job = null);
    /**
     * @var $name string
     */
    public function setName($name);

    public function init();
}