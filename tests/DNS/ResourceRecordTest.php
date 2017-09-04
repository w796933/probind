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
use App\Models\DNS\Rdata\Factory;
use App\Models\DNS\ResourceRecord;

class ResourceRecordTest extends \TestCase
{
    /**
     * @expectedException \UnexpectedValueException
     */
    public function testSetClass()
    {
        $rr = new ResourceRecord();
        $rr->setClass(Classes::INTERNET);
        $this->assertEquals(Classes::INTERNET, $rr->getClass());
        $rr->setClass('XX');
    }

    /**
     * Tests the getter and setter methods
     */
    public function testSettersAndGetters()
    {
        $rr = new ResourceRecord();
        $name = 'test';
        $ttl = 3500;
        $comment = 'Hello';
        $a = Factory::A('192.168.7.7');
        $rr->setName($name);
        $rr->setClass(Classes::INTERNET);
        $rr->setRdata($a);
        $rr->setTtl($ttl);
        $rr->setComment($comment);
        $this->assertEquals($a, $rr->getRdata());
        $this->assertEquals($name, $rr->getName());
        $this->assertEquals($ttl, $rr->getTtl());
        $this->assertEquals($comment, $rr->getComment());
        $this->assertEquals($a->getType(), $rr->getType());
    }
}