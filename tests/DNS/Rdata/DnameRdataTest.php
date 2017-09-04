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

use App\Models\DNS\Rdata\DnameRdata;

class DnameRdataTest extends \TestCase
{
    public function testSetTarget()
    {
        $target = 'foo.example.com.';
        $dname = new DnameRdata();
        $dname->setTarget($target);
        $this->assertEquals($target, $dname->getTarget());
    }

    public function testOutput()
    {
        $target = 'foo.example.com.';
        $dname = new DnameRdata();
        $dname->setTarget($target);
        $this->assertEquals($target, $dname->output());
    }
}