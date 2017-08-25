<?php

/**
 * Author: miro@keboola.com
 * Date: 24/08/2017
 */

namespace Keboola\ProjectValidator\Rules;

use Keboola\StorageApi\Client;

class HasMysqlBackendTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $this->assertTrue(
            (new HasMysqlBackend(
                new Client(['token' => getenv('KBC_TOKEN')])
            )) ()
        );
    }
}
