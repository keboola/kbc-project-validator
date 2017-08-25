<?php
/**
 * Author: miro@keboola.com
 * Date: 25/08/2017
 */

namespace Keboola\ProjectValidator\Rules;


class HasSysStage
{
    private $buckets;

    public function __construct($buckets)
    {
        $this->buckets = $buckets;
    }

    // return true if project has sys buckets or tables
    public function __invoke()
    {
        // iterate through project buckets and check their backend
        foreach ($this->buckets as $bucket) {
            if (strtolower($bucket['stage']) === 'sys') {
                return true;
            }
        }

        return false;
    }
}