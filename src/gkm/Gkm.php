<?php

namespace Gkm;

use Gkm\GkmClient;
use Gkm\Service\BasicGeokretyXmlParser;
use Gkm\Domain\GeoKrety;
use Gkm\Domain\GeokretyNotFoundException;


/**
 * Gkm : GeoKretyMap
 */
class Gkm {
    private $client;

    public function __construct($gkmApiEndpoint = 'https://api.geokretymap.org') {
        $this->client = new GkmClient($gkmApiEndpoint);
    }

    public function getGeokretyById($geokretyId) {
        try {
            $response = $this->client->getBasicGeokretyById($geokretyId);
            if ($response->getStatusCode() != 200) {
                throw new GeokretyNotFoundException();
            }
            $responseBodyString = (string) $response->getBody();
            $arrayOfGeokrety = BasicGeokretyXmlParser::parse($responseBodyString);
            if (count($arrayOfGeokrety) == 0) {
                throw new GeokretyNotFoundException();
            }
            return $arrayOfGeokrety[0];
        } catch (ClientException $clientException) {
            if ($clientException->getResponse()->getStatusCode() == 404) {
                throw new GeokretyNotFoundException();
            }
            throw $clientException;
        }
    }

    public function getGeokretyByIds($arrayOfGeokretyIds) {
        try {
            $response = $this->client->getBasicGeokretyByIds($arrayOfGeokretyIds);
            if ($response->getStatusCode() != 200) {
                throw new GeokretyNotFoundException();
            }
            $responseBodyString = (string) $response->getBody();
            return BasicGeokretyXmlParser::parse($responseBodyString);
        } catch (ClientException $clientException) {
            if ($clientException->getResponse()->getStatusCode() == 404) {
                throw new GeokretyNotFoundException();
            }
            throw $clientException;
        }
    }
}