<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 08.12.2016 10:36
 */

/**
 * Class ComponentTest
 * @property \Codeception\Module\Yii2 $tester
 */
class ComponentTest extends Codeception\Test\Unit
{
    public function testGearmanExtension()
    {
        $this->assertTrue(extension_loaded('gearman'));
    }

    public function testGearmanComponent()
    {
        Yii::$app->set('gearman', [
            'class' => 'miserenkov\gearman\Gearman',
            'servers' => [
                ['host' => '127.0.0.1', 'port' => 4730],
            ],
            'user' => 'www-data',
            'jobs' => [
                'testJob' => [
                    'class' => 'data\TestJob'
                ],
            ]
        ]);

        Yii::$app->controllerMap['gearman'] = [
            'class' => 'miserenkov\gearman\controllers\GearmanController',
            'gearmanComponent' => 'gearman'
        ];

        for ($i = 0; $i < 10000; $i++) {
            Yii::$app->gearman->getDispatcher()->background('testJob', new \miserenkov\gearman\JobWorkload([
                'params' => [
                    'data' => $i
                ]
            ]));
        }

        Yii::$app->runAction('gearman/start', [
            'id' => 1,
        ]);
    }
}