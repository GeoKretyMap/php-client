<?php

namespace Gkm\Service;

use Gkm\Domain\Geokrety;

class BasicGeokretyXmlParser {

    public static function parse($xmlBasicDocument) {
        $arrayOfGeokrety = [];
        if ($xmlBasicDocument == null) {
            return $arrayOfGeokrety;
        }

        $loadedObject = simplexml_load_string($xmlBasicDocument);
        if (!isset($loadedObject->geokrety)) {
            return $arrayOfGeokrety;
        }

        $i = 0;
        while (isset($loadedObject->geokrety->geokret[$i])) {
            $geokretObject = $loadedObject->geokrety->geokret[$i];
            $geokrety = new Geokrety();
            $geokrety->id = (string)$geokretObject->attributes()->id;
            $geokrety->dateMoved = (string)$geokretObject->attributes()->date; // no time
            $geokrety->ownerName = (string)$geokretObject->attributes()->ownername;
            $geokrety->ownerId = (string)$geokretObject->attributes()->owner_id;
            $geokrety->distanceTraveledKm = (int)$geokretObject->attributes()->dist;
            $geokrety->waypointCode = (string)$geokretObject->attributes()->waypoint;
            $geokrety->state = (string)$geokretObject->attributes()->state;
            $geokrety->typeId = (string)$geokretObject->attributes()->type;
            $geokrety->positionLat = (string)$geokretObject->attributes()->lat;
            $geokrety->positionLon = (string)$geokretObject->attributes()->lon;
            $geokrety->imageSrc = (string)$geokretObject->attributes()->image;
            // no image title
            $geokrety->name = (string)$geokretObject;
            $geokrety->lastMoveId= (string)$geokretObject->attributes()->last_log_id;
            array_push($arrayOfGeokrety, $geokrety);
            $i++;
        }
        return $arrayOfGeokrety;
    }
}