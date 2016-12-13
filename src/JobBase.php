<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 17:01
 */

namespace miserenkov\gearman;


use yii\base\Component;

abstract class JobBase extends Component implements JobInterface
{
    protected $name;

    public function init()
    {
        return true;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @param \GearmanJob $job
     * @return JobWorkload
     */
    public function getWorkload(\GearmanJob $job)
    {
        $workload = null;
        if($data = $job->workload()) {
            $workload = unserialize($data);
        }
        return $workload;
    }
}