<?php

/**
 * Created by Miroslav Čillík <miro@keboola.com>
 * Date: 23/08/17
 * Time: 15:22
 */

namespace Keboola\ProjectValidator;

use GuzzleHttp\Exception\RequestException;
use Keboola\ProjectValidator\Exception\ApplicationException;
use Keboola\ProjectValidator\Exception\UserException;
use Keboola\ProjectValidator\Rules\HasMysqlBackend;
use Keboola\StorageApi\Client;
use Monolog\Handler\NullHandler;
use Pimple\Container;

class Application
{
    private $container;

    public function __construct($config)
    {
        $container = new Container();
        $container['logger'] = function ($c) {
            $logger = new Logger(APP_NAME);
            if ($c['action'] !== 'run') {
                $logger->setHandlers([new NullHandler(Logger::INFO)]);
            }
            return $logger;
        };

        $container['storage_api_client'] = function () {
            return new Client([
                'token' => getenv('KBC_TOKEN')
            ]);
        };

        $this->container = $container;
    }

    public function run()
    {
        $actionMethod = $this->container['action'] . 'Action';
        if (!method_exists($this, $actionMethod)) {
            throw new UserException(sprintf("Action '%s' does not exist.", $this['action']));
        }

        try {
            return $this->$actionMethod();
        } catch (RequestException $e) {
            if ($e->getCode() == 400) {
                throw new UserException($e->getMessage());
            }
            throw new ApplicationException($e->getMessage(), 500, $e, [
                'response' => $e->getResponse()->getBody()->getContents()
            ]);
        }
    }

    protected function runAction()
    {
        return [
            'hasMysqlBackend' => (new HasMysqlBackend($this->container['storage_api_client']))()
        ];
    }
}
