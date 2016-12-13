<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 13.12.2016 10:07
 */

namespace miserenkov\gearman\lib;


use yii\base\Object;
use yii\log\Logger as YiiLogger;

class Logger extends Object
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
    public function emergency($message)
    {
        $this->log(YiiLogger::LEVEL_INFO, $message);
    }

    /**
     * @inheritdoc
     */
    public function alert($message)
    {
        $this->log(YiiLogger::LEVEL_ERROR, $message);
    }

    /**
     * @inheritdoc
     */
    public function critical($message)
    {
        $this->log(YiiLogger::LEVEL_ERROR, $message);
    }

    /**
     * @inheritdoc
     */
    public function error($message)
    {
        $this->log(YiiLogger::LEVEL_ERROR, $message);
    }

    /**
     * @inheritdoc
     */
    public function warning($message)
    {
        $this->log(YiiLogger::LEVEL_WARNING, $message);
    }

    /**
     * @inheritdoc
     */
    public function notice($message)
    {
        $this->log(YiiLogger::LEVEL_INFO, $message);
    }

    /**
     * @inheritdoc
     */
    public function info($message)
    {
        $this->log(YiiLogger::LEVEL_INFO, $message);
    }

    /**
     * @inheritdoc
     */
    public function debug($message)
    {
        $this->log(YiiLogger::LEVEL_TRACE, $message);
    }

    /**
     * @inheritdoc
     */
    public function log($level, $message)
    {
        $this->logger->log($message, $level, 'miserenkov\gearman');
    }
}