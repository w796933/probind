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

namespace DNS;

use App\Models\DNS\Classes;

class ClassesTest extends \TestCase
{
    public function testIsValidClass()
    {
        $this->assertTrue(Classes::isValid('IN'));
        $this->assertTrue(Classes::isValid('HS'));
        $this->assertTrue(Classes::isValid('CH'));
        $this->assertFalse(Classes::isValid('INTERNET'));
        $this->assertFalse(Classes::isValid('in'));
        $this->assertFalse(Classes::isValid('In'));
        $this->assertFalse(Classes::isValid('hS'));
    }
}