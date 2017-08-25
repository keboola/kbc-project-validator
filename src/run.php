<?php

use Keboola\ProjectValidator\Application;
use Keboola\ProjectValidator\Exception\ApplicationException;
use Keboola\ProjectValidator\Exception\UserException;
use Monolog\Logger;

require_once(__DIR__ . "/bootstrap.php");

$logger = new Logger(APP_NAME);

try {
    $arguments = getopt("d::", ["data::"]);
    if (!isset($arguments["data"])) {
        throw new UserException('Data folder not set.');
    }
    $config = json_decode(file_get_contents($arguments["data"] . "/config.json"), true);
    $config['parameters']['data_dir'] = $arguments['data'];

    $app = new Application($config);
    $result = $app->run();

    if (isset($config['action'])) {
        echo json_encode($result);
        exit(0);
    }
} catch (UserException $e) {
    if (isset($config['action']) && $config['action'] != 'run') {
        echo json_encode([
            'status' => 'error',
            'error' => 'User Error',
            'message' => $e->getMessage()
        ]);
    } else {
        $logger->log('error', $e->getMessage(), (array) $e->getData());
    }
    exit(1);
} catch (ApplicationException $e) {
    $logger->log('error', $e->getMessage(), (array) $e->getData());
    exit(2);
} catch (\Exception $e) {
    $logger->log('error', $e->getMessage(), [
        'errFile' => $e->getFile(),
        'errLine' => $e->getLine(),
        'trace' => $e->getTrace()
    ]);
    exit(2);
}

$logger->log('info', "Writer finished successfully.");
exit(0);
