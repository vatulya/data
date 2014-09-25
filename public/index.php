<?php

defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__ . '/../app/');

require __DIR__ . '/../vendor/autoload.php';

require_once APPLICATION_PATH . '/config/config.php';

\Controller\AbstractController::load(getArrayValue($_REQUEST, 'controller'), getArrayValue($_REQUEST, 'action'));