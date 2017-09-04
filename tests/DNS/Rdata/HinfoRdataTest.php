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

use App\Models\DNS\Rdata\HinfoRdata;

class HinfoRdataTest extends \TestCase
{
    public function testOutput()
    {
        $cpu = '2.7GHz';
        $os = 'Ubuntu 12.04';
        $expectation = '"2.7GHz" "Ubuntu 12.04"';
        $hinfo = new HinfoRdata();
        $hinfo->setCpu($cpu);
        $hinfo->setOs($os);
        $this->assertEquals($expectation, $hinfo->output());
    }

    public function testGetters()
    {
        $cpu = '2.7GHz';
        $os = 'Ubuntu 12.04';
        $hinfo = new HinfoRdata();
        $hinfo->setCpu($cpu);
        $hinfo->setOs($os);
        $this->assertEquals($cpu, $hinfo->getCpu());
        $this->assertEquals($os, $hinfo->getOs());
    }
}