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

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @var $name string
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    public function init(){
        return true;
    }

    /**
     * @param \GearmanJob $job
     * @return JobWorkload
     */
    protected function getWorkload(\GearmanJob $job)
    {
        $workload = null;
        if($data = $job->workload()) {
            $workload = unserialize($data);
        }
        return $workload;
    }
}