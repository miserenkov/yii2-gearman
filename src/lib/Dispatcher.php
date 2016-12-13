<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 17:00
 */

namespace miserenkov\gearman\lib;


class Dispatcher
{
    const NORMAL = 0;
    const LOW = 1;
    const HIGH = 2;

    /**
     * @var Client
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
     * @param Config $config
     * @param Logger|null $logger
     */
    public function __construct(Config $config, Logger $logger = null)
    {
        $this->setConfig($config);
        if ($logger !== null) {
            $this->setLogger($logger);
        }
    }

    /**
     * @param string $name
     * @param mixed $data
     * @param int $priority
     * @param string $unique
     * @return bool
     */
    public function background($name, $data = null, $priority = self::NORMAL, $unique = null)
    {
        $client = $this->getClient()->getClient();
        if ($this->logger !== null) {
            $this->logger->debug("Sent background job \"{$name}\" to GearmanClient");
        }
        $jobHandle = null;
        switch ($priority) {
            case self::LOW:
                $jobHandle = $client->doLowBackground($name, self::serialize($data), $unique);
                break;
            case self::HIGH:
                $jobHandle = $client->doHighBackground($name, self::serialize($data), $unique);
                break;
            default:
                $jobHandle = $client->doBackground($name, self::serialize($data), $unique);
                break;
        }
        if ($client->returnCode() !== GEARMAN_SUCCESS) {
            if ($this->logger !== null) {
                $this->logger->error("Bad return code");
            }
        }
        if ($this->logger !== null) {
            $this->logger->info("Sent job \"{$jobHandle}\" to GearmanWorker");
        }

        return $client->returnCode() === GEARMAN_SUCCESS;
    }

    /**
     * @param string $name
     * @param mixed $data
     * @param int $priority
     * @param string $unique
     * @return mixed
     */
    public function execute($name, $data = null, $priority = self::NORMAL, $unique = null)
    {
        $client = $this->getClient()->getClient();
        if ($this->logger !== null) {
            $this->logger->debug("Sent job \"{$name}\" to GearmanClient");
        }
        $result = null;
        switch ($priority) {
            case self::LOW:
                $result = $client->doLow($name, self::serialize($data), $unique);
                break;
            case self::HIGH:
                $result = $client->doHigh($name, self::serialize($data), $unique);
                break;
            default:
                $result = $client->doNormal($name, self::serialize($data), $unique);
                break;
        }
        if ($client->returnCode() !== GEARMAN_SUCCESS) {
            if ($this->logger !== null) {
                $this->logger->error("Bad return code");
            }
        }
        if ($this->logger !== null) {
            $this->logger->debug("Job \"{$name}\" returned {$result}");
        }
        return unserialize($result);
    }

    /**
     * @param mixed $data
     * @return string
     */
    private function serialize($data = [])
    {
        return serialize($data);
    }

    /**
     * @param Client|null $client
     * @return $this
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return Client|null
     */
    public function getClient()
    {
        if ($this->client === null) {
            $this->setClient(new Client($this->getConfig(), $this->getLogger()));
        }
        return $this->client;
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
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
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