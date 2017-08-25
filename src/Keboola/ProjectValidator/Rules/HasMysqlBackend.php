<?php

/**
 * Author: miro@keboola.com
 * Date: 24/08/2017
 */

namespace Keboola\ProjectValidator\Rules;

class HasMysqlBackend
{
    private $buckets;

    public function __construct($buckets)
    {
        $this->buckets = $buckets;
    }

    // return true if project buckets run on MySQL backend, false otherwise
    public function __invoke()
    {
        // iterate through project buckets and check their backend
        foreach ($this->buckets as $bucket) {
            if (strtolower($bucket['backend']) === 'mysql') {
                return true;
            }
        }

        return false;
    }
}
