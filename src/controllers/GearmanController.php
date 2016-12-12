<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 16:47
 */

namespace miserenkov\gearman\controllers;

use miserenkov\gearman\Gearman;
use yii\console\Controller;
use yii\helpers\Console;
use miserenkov\gearman\lib\Application;
use miserenkov\gearman\lib\Process;

class GearmanController extends Controller
{
    /**
     * @var boolean whether to run the forked process.
     */
    public $fork = true;

    public $gearmanComponent = 'gearman';

    public function actionStart($id = 1)
    {
        $app = $this->getApplication($id);
        $process = $app->getProcess($id);

        if ($process->isRunning()) {
            $this->stdout("Failed: Process is already running\n", Console::FG_RED);
            return;
        }

        $this->runApplication($app);
    }

    public function actionStop($id)
    {
        $app = $this->getApplication($id);
        $process = $app->getProcess($id);

        if ($process->isRunning()) {
            $this->stdout("Success: Process is stopped\n", Console::FG_GREEN);
        } else {
            $this->stdout("Failed: Process is not stopped\n", Console::FG_RED);
        }

        $process->stop();
    }

    public function actionRestart($id)
    {
        $app = $this->getApplication($id);
        $process = $app->getProcess($id);

        if (!$process->isRunning()) {
            $this->stdout("Failed: Process is not running\n", Console::FG_RED);
            return;
        }

        unlink($process->getPidFile());
        $process->release();
        $int = 0;
        while ($int < 1000) {
            if (file_exists($process->getPidFile())) {
                usleep(1000);
                $int++;
            } elseif (file_exists($process->getLockFile())) {
                $process->release();
                usleep(1000);
                $int++;
            } else {
                $int = 1000;
            }
        }

        $app->setProcess(new Process($app->getConfig(), $id, $app->getLogger()));
        $this->runApplication($app);
    }

    public function options($id)
    {
        $options = [];
        if(in_array($id, ['start', 'restart'])) {
            $options = ['fork'];
        }

        return array_merge(parent::options($id), $options);
    }

    /**
     * @param $id
     * @return Gearman
     */
    protected function getApplication($id)
    {
        $component = \Yii::$app->get($this->gearmanComponent);
        return $component->getApplication($id);
    }

    protected function runApplication(Application $app)
    {
        $fork = (bool) $this->fork;
        if($fork) {
            $this->stdout("Success: Process is started\n", Console::FG_GREEN);
        } else {
            $this->stdout("Success: Process is started, but not daemonized\n", Console::FG_YELLOW);
        }

        $app->run((bool) $this->fork);
    }
}