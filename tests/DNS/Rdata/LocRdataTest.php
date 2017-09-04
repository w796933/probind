<?php
/**
 * ProBIND v3 - Professional DNS management made easy.
 *
 * Copyright (c) 2017 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE, AUTHORS.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2017 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 * @link               https://github.com/pacoorozco/probind
 */

namespace DNS\Rdata;

use App\Models\DNS\Rdata\LocRdata;

class LocRdataTest extends \TestCase
{
    public function testOutput()
    {
        $rdata = new LocRdata();
        $rdata->setLatitude(-35.3075);
        $rdata->setLongitude(149.1244);
        $rdata->setAltitude(500);
        $rdata->setSize(20.12);
        $rdata->setHorizontalPrecision(200.3);
        $rdata->setVerticalPrecision(300.1);
        $expected = '35 18 27.000 S 149 7 27.840 E 500.00m 20.12m 200.30m 300.10m';
        $this->assertEquals($expected, $rdata->output());
    }

    public function testSetLatitude()
    {
        $latitude = -35.3075;
        $lat_dms = '35 18 27.000 S';
        $rdata = new LocRdata();
        $rdata->setLatitude($latitude);
        $this->assertEquals($latitude, $rdata->getLatitude($latitude));
        $this->assertEquals($lat_dms, $rdata->getLatitude(LocRdata::FORMAT_DMS));
    }

    public function testSetLongitude()
    {
        $longitude = 149.1244;
        $lon_dms = '149 7 27.840 E';
        $rdata = new LocRdata();
        $rdata->setLongitude($longitude);
        $this->assertEquals($longitude, $rdata->getLongitude($longitude));
        $this->assertEquals($lon_dms, $rdata->getLongitude(LocRdata::FORMAT_DMS));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testSetAltitude1()
    {
        $rdata = new LocRdata();
        $rdata->setAltitude(-100001);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testSetAltitude2()
    {
        $rdata = new LocRdata();
        $rdata->setAltitude(42849673);
    }

    public function testGetAltitude()
    {
        $rdata = new LocRdata();
        $altitude = 12345;
        $rdata->setAltitude($altitude);
        $this->assertEquals($altitude, $rdata->getAltitude());
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testSetSize1()
    {
        $rdata = new LocRdata();
        $rdata->setSize(-1);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testSetSize2()
    {
        $rdata = new LocRdata();
        $rdata->setSize(90000002);
    }

    public function testGetSize()
    {
        $size = 1231;
        $rdata = new LocRdata();
        $rdata->setSize($size);
        $this->assertEquals($size, $rdata->getSize());
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testSetVerticalPrecision1()
    {
        $rdata = new LocRdata();
        $rdata->setVerticalPrecision(-1);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testSetVerticalPrecision2()
    {
        $rdata = new LocRdata();
        $rdata->setVerticalPrecision(90000002);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testSetHorizontalPrecision1()
    {
        $rdata = new LocRdata();
        $rdata->setHorizontalPrecision(-1);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testSetHorizontalPrecision2()
    {
        $rdata = new LocRdata();
        $rdata->setHorizontalPrecision(90000002);
    }

    public function testGetHorizontalPrecision()
    {
        $hp = 127835;
        $rdata = new LocRdata();
        $rdata->setHorizontalPrecision($hp);
        $this->assertEquals($hp, $rdata->getHorizontalPrecision());
    }

    public function testGetVerticalPrecision()
    {
        $vp = 127835;
        $rdata = new LocRdata();
        $rdata->setVerticalPrecision($vp);
        $this->assertEquals($vp, $rdata->getVerticalPrecision());
    }
}