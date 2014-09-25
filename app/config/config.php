<?php

require_once 'class.php';

Config::getInstance()->load([
    'data' => [
        'sources' => [
            'json' => [
                'filename' => '../data/data.json',
            ],
            'php' => [
                'filename' => '../data/data.php',
            ],
            'xml' => [
                'filename' => '../data/data.xml',
            ],
        ],
    ],
]);