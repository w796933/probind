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

use App\Models\DNS\Rdata\SoaRdata;
use App\Models\DNS\Rdata\Factory;

class SoaRdataTest extends \TestCase
{
    public function testSettersAndGetters()
    {
        $soa = new SoaRdata();
        $mname = 'example.com.';
        $rname = 'post.example.com.';
        $serial = 1970010101;
        $refresh = 3600;
        $retry = 14400;
        $expire = 604800;
        $minimum = 3600;
        $soa->setMname($mname);
        $soa->setRname($rname);
        $soa->setSerial($serial);
        $soa->setRefresh($refresh);
        $soa->setRetry($retry);
        $soa->setExpire($expire);
        $soa->setMinimum($minimum);
        $this->assertEquals($mname, $soa->getMname());
        $this->assertEquals($rname, $soa->getRname());
        $this->assertEquals($serial, $soa->getSerial());
        $this->assertEquals($refresh, $soa->getRefresh());
        $this->assertEquals($retry, $soa->getRetry());
        $this->assertEquals($expire, $soa->getExpire());
        $this->assertEquals($minimum, $soa->getMinimum());
    }

    /**
     * @expectedException \App\Models\DNS\Rdata\RdataException
     */
    public function testSetMnameException()
    {
        $target = 'foo.example.com';
        $soa = new SoaRdata();
        $soa->setMname($target);
    }

    /**
     * @expectedException \App\Models\DNS\Rdata\RdataException
     */
    public function testSetRnameException()
    {
        $target = 'foo.example.com';
        $soa = new SoaRdata();
        $soa->setRname($target);
    }

    public function testOutput()
    {
        $soa = Factory::Soa(
            'example.com.',
            'postmaster.example.com.',
            '2015042101',
            3600,
            14400,
            604800,
            3600
        );
        $expected = 'example.com. postmaster.example.com. 2015042101 3600 14400 604800 3600';
        $this->assertEquals($expected, $soa->output());
    }
}