<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 17:04
 */

namespace miserenkov\gearman\lib;


use miserenkov\gearman\exceptions\ServerConnectionException;

class Worker
{
    /**
     * @var \GearmanWorker
     */
    private $worker;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var array
     */
    private $functions = [];

    /**
     * @param Config $config
     * @param null|Logger $logger
     * @throws ServerConnectionException
     */
    public function __construct(Config $config, Logger $logger = null)
    {
        $this->setConfig($config);
        if ($logger !== null) {
            $this->setLogger($logger);
        }
    }

    public function resetWorker()
    {
        if ($this->worker instanceof \GearmanWorker) {
            $this->worker->unregisterAll();
        }
        $this->worker = null;
        $this->createWorker();
    }

    /**
     * @throws ServerConnectionException
     */
    private function createWorker()
    {
        $this->worker = new \GearmanWorker();
        $servers = $this->getConfig()->getServers();
        $exceptions = [];
        foreach ($servers as $server) {
            try {
                $this->worker->addServer($server->getHost(), $server->getPort());
            } catch (\GearmanException $e) {
                $message = 'Unable to connect to Gearman Server ' . $server->getHost() . ':' . $server->getPort();
                if ($this->logger !== null) {
                    $this->logger->info($message);
                }
                $exceptions[] = $message;
            }
        }
        if (count($exceptions)) {
            foreach ($exceptions as $exception) {
                throw new ServerConnectionException($exception);
            }
        }
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     * @return $this
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return \GearmanWorker
     */
    public function getWorker()
    {
        if ($this->worker === null) {
            $this->createWorker();
        }
        return $this->worker;
    }

    /**
     * @param \GearmanWorker $worker
     * @return $this
     */
    public function setWorker(\GearmanWorker $worker)
    {
        $this->worker = $worker;
        return $this;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param null|Logger $logger
     * @return $this
     */
    public function setLogger(Logger $logger = null)
    {
        $this->logger = $logger;
        return $this;
    }
}