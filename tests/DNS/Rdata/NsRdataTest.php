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

use App\Models\DNS\Rdata\NsRdata;

class NsRdataTest extends \TestCase
{
    public function testSetNsdname()
    {
        $nsdname = 'foo.example.com.';
        $dname = new NsRdata();
        $dname->setTarget($nsdname);
        $this->assertEquals($nsdname, $dname->getTarget());
    }

    public function testOutput()
    {
        $Nsdname = 'foo.example.com.';
        $dname = new NsRdata();
        $dname->setTarget($Nsdname);
        $this->assertEquals($Nsdname, $dname->output());
    }
}