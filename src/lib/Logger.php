<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 13.12.2016 10:07
 */

namespace miserenkov\gearman\lib;


use Psr\Log\LoggerInterface;
use yii\base\Object;
use yii\log\Logger as YiiLogger;

class Logger extends Object implements LoggerInterface
{
    /**
     * @var YiiLogger
     */
    private $logger = null;

    public function init()
    {
        if ($this->logger === null) {
            $this->logger = \Yii::$app->getLog()->getLogger();
        }
    }

    /**
     * @inheritdoc
     */
    public function emergency($message, array $context = array())
    {
        $this->log(YiiLogger::LEVEL_INFO, $message, $context);
    }

    /**
     * @inheritdoc
     */
    public function alert($message, array $context = array())
    {
        $this->log(YiiLogger::LEVEL_ERROR, $message, $context);
    }

    /**
     * @inheritdoc
     */
    public function critical($message, array $context = array())
    {
        $this->log(YiiLogger::LEVEL_ERROR, $message, $context);
    }

    /**
     * @inheritdoc
     */
    public function error($message, array $context = array())
    {
        $this->log(YiiLogger::LEVEL_ERROR, $message, $context);
    }

    /**
     * @inheritdoc
     */
    public function warning($message, array $context = array())
    {
        $this->log(YiiLogger::LEVEL_WARNING, $message, $context);
    }

    /**
     * @inheritdoc
     */
    public function notice($message, array $context = array())
    {
        $this->log(YiiLogger::LEVEL_INFO, $message, $context);
    }

    /**
     * @inheritdoc
     */
    public function info($message, array $context = array())
    {
        $this->log(YiiLogger::LEVEL_INFO, $message, $context);
    }

    /**
     * @inheritdoc
     */
    public function debug($message, array $context = array())
    {
        $this->log(YiiLogger::LEVEL_TRACE, $message, $context);
    }

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = array())
    {
        $this->logger->log($message, $level);
    }
}