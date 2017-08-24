<?php

/**
 * Author: miro@keboola.com
 * Date: 24/08/2017
 */

namespace Keboola\ProjectValidator\Rules;

use Keboola\StorageApi\Client;

class HasMysqlBackend
{
    private $storageApiClient;

    public function __construct(Client $storageApiClient)
    {
        $this->storageApiClient = $storageApiClient;
    }

    // return true if project buckets run on MySQL backend, false otherwise
    public function __invoke()
    {
        // iterate through project buckets and check their backend
        $buckets = $this->storageApiClient->listBuckets();
        foreach ($buckets as $bucket) {
            if (strtolower($bucket['backend']) === 'mysql') {
                return true;
            }
        }

        return false;
    }
}
