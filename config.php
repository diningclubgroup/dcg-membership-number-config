<?php
/**
 * Add config as key value pairs of config parameter name and value.
 *
 * Keyed by the env. All config should sit under prod or test.
 *
 */
return [
    'prod' => [
        'live' => true
    ],
    'test' => [
        'live' => false
    ]
];