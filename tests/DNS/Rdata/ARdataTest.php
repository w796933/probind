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

use App\Models\DNS\Rdata\ARdata;

class ARdataTest extends \TestCase
{
    /**
     * @var ARdata
     */
    private $aRdata;

    public function setUp()
    {
        $this->aRdata = new ARdata();
    }

    public function testGetType()
    {
        $this->assertEquals('A', $this->aRdata->getType());
    }

    public function testSetAddress()
    {
        $address = '192.168.1.1';
        $this->aRdata->setAddress($address);
        $this->assertEquals($address, $this->aRdata->getAddress());
    }

    /**
     * @expectedException \App\Models\DNS\Rdata\RdataException
     */
    public function testException()
    {
        $invalidAddress = '192.168.256.1';
        $this->aRdata->setAddress($invalidAddress);
    }

    public function testOutput()
    {
        $address = '192.168.1.1';
        $this->aRdata->setAddress($address);
        $this->assertEquals($address, $this->aRdata->output());
    }
}