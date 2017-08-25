<?php
/**
 * Author: miro@keboola.com
 * Date: 25/08/2017
 */

namespace Keboola\ProjectValidator;

class Output
{
    private $dataDir;

    public function __construct($dataDir)
    {
        $this->dataDir = $dataDir;
    }

    public function write($data)
    {
        return file_put_contents(sprintf('%s/out/state.json', $this->dataDir), $data);
    }
}
