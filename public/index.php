<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/Core/helpers.php';

/**
 * Get Application singeleton by passing it configuration class
 */
$app = Core\Skeleton::getInstance(App\Config::class);


/**
 * Send the appropriate response back
 */
$app->sendResponse();