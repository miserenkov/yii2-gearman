<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 16:58
 */

namespace miserenkov\gearman\lib;


use miserenkov\gearman\exceptions\ServerConnectionException;

class Client
{
    /**
     * @var \GearmanClient
     */
    private $client;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var bool
     */
    private $hasServers = false;

    /**
     * @param Config $config
     * @param null|Logger $logger
     */
    public function __construct(Config $config, Logger $logger = null)
    {
        $this->setClient(new \GearmanClient());
        $this->setConfig($config);
        if ($logger !== null) {
            $this->setLogger($logger);
        }
    }

    /**
     * @return $this
     * @throws ServerConnectionException
     */
    private function addServers()
    {
        $this->hasServers = true;
        $client = $this->getClient();
        $servers = $this->getConfig()->getServers();
        $exceptions = [];
        foreach ($servers as $server) {
            try {
                $client->addServer($server->getHost(), $server->getPort());
            } catch (\GearmanException $e) {
                $message = 'Unable to connect to Gearman Server ' . $server->getHost() . ':' . $server->getPort();
                if ($this->logger !== null) {
                    $this->logger->error($message);
                }
                $exceptions[] = $message;
            }
        }
        if (count($exceptions)) {
            foreach ($exceptions as $exception) {
                throw new ServerConnectionException($exception);
            }
        }
        return $this;
    }

    /**
     * @return \GearmanClient
     */
    public function getClient()
    {
        if (!$this->hasServers) {
            $this->addServers();
        }
        return $this->client;
    }

    /**
     * @param \GearmanClient $client
     * @return $this
     */
    public function setClient(\GearmanClient $client)
    {
        $this->client = $client;
        return $this;
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
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param Logger $logger
     * @return $this
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        return $this;
    }
}