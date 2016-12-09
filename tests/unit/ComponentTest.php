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
}