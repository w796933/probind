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

use App\Models\DNS\Rdata\MxRdata;

class MxRdataTest extends \TestCase
{
    public function testSetters()
    {
        $target = 'foo.example.com.';
        $preference = 10;
        $mx = new MxRdata();
        $mx->setExchange($target);
        $mx->setPreference($preference);
        $this->assertEquals($target, $mx->getExchange());
        $this->assertEquals($preference, $mx->getPreference());
    }

    /**
     * @expectedException \App\Models\DNS\Rdata\RdataException
     */
    public function testSetTargetException()
    {
        $target = 'foo.example.com';
        $mx = new MxRdata();
        $mx->setExchange($target);
    }

    public function testOutput()
    {
        $target = 'foo.example.com.';
        $mx = new MxRdata();
        $mx->SetExchange($target);
        $mx->setPreference(42);
        $this->assertEquals('42 foo.example.com.', $mx->output());
    }
}