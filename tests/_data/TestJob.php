<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 09.12.2016 12:34
 */

namespace data;

use miserenkov\gearman\JobBase;

class TestJob extends JobBase
{
    public function getName()
    {
        return 'test job';
    }
    public function execute(\GearmanJob $job = null)
    {
        var_dump($job, $job->workload(), $job->workloadSize());
    }
}