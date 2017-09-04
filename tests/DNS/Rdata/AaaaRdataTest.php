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

use App\Models\DNS\Rdata\AaaaRdata;

class AaaaRdataTest extends \TestCase
{
    public function testSetAddress()
    {
        $address = '2003:dead:beef:4dad:23:46:bb:101';
        $aaaa = new AaaaRdata();
        $aaaa->setAddress($address);
        $this->assertEquals($address, $aaaa->getAddress());
    }

    /**
     * @expectedException \App\Models\DNS\Rdata\RdataException
     */
    public function testException()
    {
        $address = '2001::0234:C1ab::A0:aabc:003F';
        $aaaa = new AaaaRdata();
        $aaaa->setAddress($address);
    }
}