<?php

/**
 * Created by Miroslav Čillík <miro@keboola.com>
 * Date: 23/08/17
 * Time: 15:22
 */

namespace Keboola\ProjectValidator;

use Keboola\GoogleSheetsWriter\Logger\LineFormatter;
use Monolog\Handler\StreamHandler;

class Logger extends \Monolog\Logger
{
    private $debug = false;

    public function __construct($name = '')
    {
        $options = getopt("", ['debug']);
        if (isset($options['debug'])) {
            $this->debug = true;
        }

        $formatter = $this->getFormatter();
        $errHandler = new StreamHandler('php://stderr', \Monolog\Logger::NOTICE, false);
        $level = $this->debug ? \Monolog\Logger::DEBUG : \Monolog\Logger::INFO;
        $handler = new StreamHandler('php://stdout', $level);
        $handler->setFormatter($formatter);

        parent::__construct($name, [$errHandler, $handler]);
    }

    public function setDebug($bool)
    {
        $this->debug = $bool;
    }

    private function getFormatter()
    {
        if ($this->debug) {
            return new LineFormatter();
        }

        return new LineFormatter("%message%\n");
    }
}
