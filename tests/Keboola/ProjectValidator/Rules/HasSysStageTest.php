<?php
/**
 * Author: miro@keboola.com
 * Date: 25/08/2017
 */

namespace Keboola\ProjectValidator\Rules;

use Keboola\StorageApi\Client;

class HasSysStageTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $this->assertTrue(
            (new HasSysStage(
                (new Client(['token' => getenv('KBC_TOKEN')]))->listBuckets()
            )) ()
        );
    }
}
