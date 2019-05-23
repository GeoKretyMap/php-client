<?php

require 'vendor/autoload.php';

use Gkm\Gkm;
use Gkm\GkmClient;

function printResponse($response) {
    echo "status:".(string) $response->getStatusCode();
    echo " body:".(string) $response->getBody();
    echo "\n";
}

$cgeoGeokretyId = 46464;

$gkm = new Gkm();

echo "Gkm::getGeokretyById($cgeoGeokretyId) return:\n";
$geokrety = $gkm->getGeokretyById($cgeoGeokretyId);
print_r($geokrety);

echo "GkmClient::dirtyGeokretyById($cgeoGeokretyId) return:\n";
$gkmClient = new GkmClient();
$response = $gkmClient->dirtyGeokretyById($cgeoGeokretyId);
printResponse($response);

echo "GkmClient::asyncDirtyGeokretyById($cgeoGeokretyId) sent!\n";
$promise = $gkmClient->asyncDirtyGeokretyById($cgeoGeokretyId);
$promise->then(function ($response) {
    printResponse($response);
});

echo "now waiting..\n";
$promise->wait();
?>