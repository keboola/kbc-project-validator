<?php

/**
 * Author: miro@keboola.com
 * Date: 24/08/2017
 */

namespace Keboola\ProjectValidator\Rules;

class HasMysqlBackend
{
    public function __invoke()
    {
        return false;
    }
}