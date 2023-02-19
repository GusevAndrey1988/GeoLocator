<?php

use Feature\GeoLocator\ErrorHandler;
use Feature\GeoLocator\HttpClient;
use Feature\GeoLocator\Ip;
use Feature\GeoLocator\Locators\ChainLocator;
use Feature\GeoLocator\Locators\DaDataLocator;
use Feature\GeoLocator\Locators\IpGeoLocationLocator;
use Feature\GeoLocator\Locators\MuteLocator;
use Feature\GeoLocator\Loggers\SimpleFileLogger;

require_once './vendor/autoload.php';

$logger = new SimpleFileLogger(__DIR__.'/log.txt');
$errorHandler = new ErrorHandler($logger);
$httpClient = new HttpClient();

$locator = new ChainLocator(
    new MuteLocator(
        new DaDataLocator($httpClient, '8777922b10147ddd898cf1b6e21d7fef7029bc89'),
        $errorHandler
    ),
    new MuteLocator(
        new IpGeoLocationLocator($httpClient, '1f4cffbcf3814ac798efa7b5f6e15139'),
        $errorHandler
    ),
);

var_dump($locator->locate(new Ip('176.110.180.134')));