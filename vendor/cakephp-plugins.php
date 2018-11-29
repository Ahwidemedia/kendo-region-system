<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'CakePdf' => $baseDir . '/vendor/friendsofcake/cakepdf/',
        'CookieWarning' => $baseDir . '/vendor/cakephp-fr/cookie-warning/',
        'CsvView' => $baseDir . '/vendor/friendsofcake/cakephp-csvview/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'RBruteForce' => $baseDir . '/vendor/rrd/rbruteforce/',
        'Ratings' => $baseDir . '/vendor/dereuromark/cakephp-ratings/'
    ]
];