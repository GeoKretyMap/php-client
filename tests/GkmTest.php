<?php

use PHPUnit\Framework\TestCase;

use Gkm\Gkm;
use Gkm\GkmClient;
use Gkm\Domain\GeoKrety;

class MockResponse {
    public function getBody() { return "body"; }
    public function getStatusCode() { return 123; }
}

/**
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class GkmTest extends TestCase {

    const BASIC_ONE_GEOKRETY_XML = <<< EOXML
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><gkxml version="1.0" date="2019-05-17 11:31:53"><geokrety>
  <geokret date="2014-09-03" missing="1" ownername="kumy" id="46464" dist="0" lat="43.69365" lon="6.86097" waypoint="OX5BRQK" owner_id="26422" state="0" type="0" last_pos_id="586879" last_log_id="586879" image="14097735378mgfc.png">c:geo One</geokret>
</geokrety></gkxml>
EOXML;

    const BASIC_ARRAY_GEOKRETY_XML = <<< EOXML
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><gkxml version="1.0" date="2019-05-17 11:31:53"><geokrety>
  <geokret date="2014-09-03" missing="1" ownername="kumy" id="46464" dist="0" lat="43.69365" lon="6.86097" waypoint="OX5BRQK" owner_id="26422" state="0" type="0" last_pos_id="586879" last_log_id="586879" image="14097735378mgfc.png">c:geo One</geokret>
  <geokret date="2018-12-04" missing="1" ownername="bryce" id="46466" dist="8979450" lat="44.69365" lon="6.4" waypoint="OOOORQK" owner_id="26423" state="1" type="2" last_pos_id="586844" last_log_id="583333" image="pilou.png">fake One</geokret>
  <geokret missing="1" ownername="george" id="46467" dist="0" lat="45.69365" lon="6.5" owner_id="26432" state="3" type="4">ghost One</geokret>
</geokrety></gkxml>
EOXML;

    public function getCgeoGeokrety() {
        $geokrety = new Geokrety();
        $geokrety->id = "46464";
        $geokrety->dateMoved = "2014-09-03";
        $geokrety->ownerName = "kumy";
        $geokrety->ownerId = "26422";
        $geokrety->distanceTraveledKm = 0;
        $geokrety->waypointCode = "OX5BRQK";
        $geokrety->state = "0";
        $geokrety->typeId = "0";
        $geokrety->positionLat = "43.69365";
        $geokrety->positionLon = "6.86097";
        $geokrety->imageSrc = "14097735378mgfc.png";
        $geokrety->name = "c:geo One";
        $geokrety->lastMoveId = "586879";
        return $geokrety;
    }

    public function getFakeGeokrety() {
        $geokrety = new Geokrety();
        $geokrety->id = "46466";
        $geokrety->dateMoved = "2018-12-04";
        $geokrety->ownerName = "bryce";
        $geokrety->ownerId = "26423";
        $geokrety->distanceTraveledKm = 8979450;
        $geokrety->waypointCode = "OOOORQK";
        $geokrety->state = "1";
        $geokrety->typeId = "2";
        $geokrety->positionLat = "44.69365";
        $geokrety->positionLon = "6.4";
        $geokrety->imageSrc = "pilou.png";
        $geokrety->name = "fake One";
        $geokrety->lastMoveId = "583333";
        return $geokrety;
    }

    public function getIncompleteGeokrety() {
        $geokrety = new Geokrety();
        $geokrety->id = "46467";
        $geokrety->dateMoved = "";
        $geokrety->ownerName = "george";
        $geokrety->ownerId = "26432";
        $geokrety->distanceTraveledKm = 0;
        $geokrety->waypointCode = "";
        $geokrety->state = "3";
        $geokrety->typeId = "4";
        $geokrety->positionLat = "45.69365";
        $geokrety->positionLon = "6.5";
        $geokrety->imageSrc = "";
        $geokrety->name = "ghost One";
        $geokrety->lastMoveId = "";
        return $geokrety;
    }


    public function test_getGeokretyById() {
        // GIVEN
        $gkmClientStub = $this->stubGkmClient(self::BASIC_ONE_GEOKRETY_XML, self::BASIC_ARRAY_GEOKRETY_XML);
        $expectedGeokrety = $this->getCgeoGeokrety();

        $gkm = new Gkm();
        $this->setProtectedProperty($gkm, "client", $gkmClientStub);

        // WHEN
        $rez = $gkm->getGeokretyById(46464);

        // THEN
        $this->assertEquals($expectedGeokrety, $rez);
    }

    public function test_getGeokretyByIds() {
        // GIVEN
        $gkmClientStub = $this->stubGkmClient(self::BASIC_ONE_GEOKRETY_XML, self::BASIC_ARRAY_GEOKRETY_XML);
        $expectedArrayOfGeokrety = [$this->getCgeoGeokrety(),$this->getFakeGeokrety(), $this->getIncompleteGeokrety()];

        $gkm = new Gkm();
        $this->setProtectedProperty($gkm, "client", $gkmClientStub);

        // WHEN
        $rez = $gkm->getGeokretyByIds([46463, 46464, 46466, 46467]);

        // THEN
        $this->assertEquals($expectedArrayOfGeokrety, $rez);
    }

    private function stubGkmClient($xmlOneGeokretyToReturn, $xmlArrayOfGeokretyToReturn) {
        $oneGeokretyResponseStub = $this->createMock(MockResponse::class);
        $oneGeokretyResponseStub->method('getBody')->willReturn($xmlOneGeokretyToReturn);
        $oneGeokretyResponseStub->method('getStatusCode')->willReturn(200);

        $arrayOfGeokretyResponseStub = $this->createMock(MockResponse::class);
        $arrayOfGeokretyResponseStub->method('getBody')->willReturn($xmlArrayOfGeokretyToReturn);
        $arrayOfGeokretyResponseStub->method('getStatusCode')->willReturn(200);

        $gkmClientStub = $this->createMock(GkmClient::class);

        $gkmClientStub->method('getBasicGeokretyById')
                     ->willReturn($oneGeokretyResponseStub);

        $gkmClientStub->method('getBasicGeokretyByIds')
                     ->willReturn($arrayOfGeokretyResponseStub);

        return $gkmClientStub;
    }

    // src: https://stackoverflow.com/questions/18558183/phpunit-mockbuilder-set-mock-object-internal-property
    /**
     * Sets a protected property on a given object via reflection
     *
     * @param $object - instance in which protected value is being modified
     * @param $property - property on instance being modified
     * @param $value - new value of the property being modified
     *
     * @return void
     */
    public function setProtectedProperty($object, $property, $value)
    {
        $reflection = new ReflectionClass($object);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $value);
    }

}
