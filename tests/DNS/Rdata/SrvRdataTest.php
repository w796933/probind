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

use App\Models\DNS\Rdata\SrvRdata;

class SrvRdataTest extends \TestCase
{
    public function testOutput()
    {
        $srv = new SrvRdata;
        $srv->setPort(666);
        $srv->setPriority(10);
        $srv->setWeight(20);
        $srv->setTarget('doom.example.com.');
        $expectation = '10 20 666 doom.example.com.';
        $this->assertEquals($expectation, $srv->output());
    }
}