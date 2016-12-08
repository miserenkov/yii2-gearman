<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 16:57
 */

namespace miserenkov\gearman\lib;


interface BootstrapInterface
{
    public function run(Application $application);
}