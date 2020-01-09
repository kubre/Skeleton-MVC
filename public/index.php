<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/Core/helpers.php';

/**
 * Get the configuration
 */
$appConfig = App\Config::getConfig();

/**
 * Get Application singeleton
 */
$app = Core\Skeleton::getInstance($appConfig);


/**
 * Send the appropriate response back
 */
$app->sendResponse();