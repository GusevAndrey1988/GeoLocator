<?php

use Feature\GeoLocator\Cache\SimpleFileCache;
use Feature\GeoLocator\ErrorHandler;
use Feature\GeoLocator\HttpClients\SimpleHttpClient;
use Feature\GeoLocator\Ip;
use Feature\GeoLocator\Locators\CacheLocator;
use Feature\GeoLocator\Locators\ChainLocator;
use Feature\GeoLocator\Locators\DaDataLocator;
use Feature\GeoLocator\Locators\IpGeoLocationLocator;
use Feature\GeoLocator\Locators\MuteLocator;
use Feature\GeoLocator\Loggers\SimpleFileLogger;

require_once './vendor/autoload.php';

$cache = new SimpleFileCache(__DIR__.'/cache');
$logger = new SimpleFileLogger(__DIR__.'/log.txt');
$errorHandler = new ErrorHandler($logger);
$httpClient = new SimpleHttpClient();

$locator = new CacheLocator(
    new ChainLocator(
        new MuteLocator(
            new DaDataLocator($httpClient, getenv('DADATA_API_KEY')),
            $errorHandler
        ),
        new MuteLocator(
            new IpGeoLocationLocator($httpClient, getenv('IPGEOLOCATION_API_KEY')),
            $errorHandler
        ),
    ),
    $cache
);

var_dump($locator->locate(new Ip('8.8.8.8')));