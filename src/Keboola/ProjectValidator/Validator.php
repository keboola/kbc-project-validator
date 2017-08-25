<?php
/**
 * Author: miro@keboola.com
 * Date: 25/08/2017
 */

namespace Keboola\ProjectValidator;

use Keboola\ProjectValidator\Rules\HasMysqlBackend;
use Keboola\ProjectValidator\Rules\HasSysStage;
use Keboola\StorageApi\Client;
use Keboola\StorageApi\Components;
use Keboola\StorageApi\Options\Components\ListComponentConfigurationsOptions;

class Validator
{
    private $storageApiClient;

    public function __construct(Client $storageApiClient)
    {
        $this->storageApiClient = $storageApiClient;
    }

    public function validate()
    {
        $buckets = $this->storageApiClient->listBuckets();
        $tables = $this->storageApiClient->listTables();

        $componentsApi = new Components($this->storageApiClient);
        $configurations = $componentsApi->listComponentConfigurations(
            (new ListComponentConfigurationsOptions())
                ->setIsDeleted(false)
        );

        return [
            'hasMysqlBackend' => (new HasMysqlBackend($buckets)) (),
            'hasSysStage' => (new HasSysStage($buckets)) ()
        ];
    }
}
