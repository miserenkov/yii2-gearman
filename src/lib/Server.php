<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 17:03
 */

namespace miserenkov\gearman\lib;


class Server implements \Serializable
{
    /**
     * @var string
     */
    private $host = '127.0.0.1';

    /**
     * @var int
     */
    private $port = 4730;

    /**
     * @param string|null $host
     * @param int|null $port
     */
    public function __construct($host = null, $port = null)
    {
        if ($host !== null) {
            $this->setHost($host);
        }
        if ($port !== null) {
            $this->setPort($port);
        }
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return $this
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize([
            'host' => $this->getHost(),
            'port' => $this->getPort(),
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        if (isset($data['host'])) {
            $this->setHost($data['host']);
        }
        if (isset($data['port'])) {
            $this->setPort($data['port']);
        }
    }
}