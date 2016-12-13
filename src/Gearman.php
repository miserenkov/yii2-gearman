<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 16:44
 */

namespace miserenkov\gearman;


use miserenkov\gearman\lib\Application;
use miserenkov\gearman\lib\Config;
use miserenkov\gearman\lib\Dispatcher;
use miserenkov\gearman\lib\Logger;
use miserenkov\gearman\lib\Process;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Gearman extends Component
{
    public $servers;

    public $user;

    public $jobs = [];

    private $_application;

    private $_dispatcher;

    private $_config;

    private $_process;

    private $_logger;

    /**
     * @param integer $id
     * @return Application
     * @throws InvalidConfigException
     */
    public function getApplication($id)
    {
        if($this->_application === null) {
            $app = new Application($id, $this->getConfig(), $this->getProcess($id), null, $this->getLogger());
            foreach($this->jobs as $name => $job) {
                $job = \Yii::createObject($job);
                if(!($job instanceof JobInterface)) {
                    throw new InvalidConfigException('Gearman job must be instance of JobInterface.');
                }

                $job->setName($name);
                $app->add($job);
            }
            $this->_application = $app;
        }

        return $this->_application;
    }

    public function getDispatcher()
    {
        if($this->_dispatcher === null) {
            $this->_dispatcher = new Dispatcher($this->getConfig());
        }

        return $this->_dispatcher;
    }

    public function getConfig()
    {
        if($this->_config === null) {
            $servers = [];
            foreach($this->servers as $server) {
                if(is_array($server) && isset($server['host'], $server['port'])) {
                    $servers[] = implode(Config::SERVER_PORT_SEPARATOR, [$server['host'], $server['port']]);
                } else {
                    $servers[] = $server;
                }
            }
            $this->_config = new Config([
                'servers' => $servers,
                'user' => $this->user
            ]);
        }

        return $this->_config;
    }

    public function setConfig(Config $config)
    {
        $this->_config = $config;
        return $this;
    }

    /**
     * @return Process
     */
    public function getProcess($id)
    {
        if ($this->_process === null) {
            $this->setProcess((new Process($this->getConfig(), $id)));
        }
        return $this->_process;
    }

    /**
     * @param Process $process
     * @return $this
     */
    public function setProcess(Process $process)
    {
        if ($this->getConfig() === null && $process->getConfig() instanceof Config) {
            $this->setConfig($process->getConfig());
        }
        $this->_process = $process;
        return $this;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        if ($this->_logger === null) {
            $this->_logger = new Logger();
        }

        return $this->_logger;
    }
}