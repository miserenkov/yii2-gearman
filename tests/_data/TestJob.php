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
    public function execute(\GearmanJob $job = null)
    {
        ob_start();
        var_dump($job, $job->workload(), $job->workloadSize(), $job->unique(), $job->functionName(), $job->handle(), $job->returnCode());
        file_put_contents(__DIR__.'/../_output/log.txt', ob_get_contents(), FILE_APPEND);
    }
}