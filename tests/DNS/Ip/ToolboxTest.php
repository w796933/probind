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

namespace DNS\Ip;

use App\Models\DNS\Ip\Toolbox;

class ToolboxTest extends \TestCase
{
    /**
     *
     */
    public function testExpandIpv6()
    {
        $case_1 = '::1';
        $case_2 = '2001:db8::ff00:42:8329';
        $exp_1 = '0000:0000:0000:0000:0000:0000:0000:0001';
        $exp_2 = '2001:0db8:0000:0000:0000:ff00:0042:8329';
        $this->assertEquals($exp_1, Toolbox::expandIpv6($case_1));
        $this->assertEquals($exp_2, Toolbox::expandIpv6($case_2));
    }

    public function testContractIpv6()
    {
        $case_1 = '0000:0000:0000:0000:0000:0000:0000:0001';
        $case_2 = '2001:0db8:0000:0000:0000:ff00:0042:8329';
        $case_3 = '2001:0000:0000:acad:0000:0000:0000:0001';
        $case_4 = '2001:db8::ff00:42:8329';
        $case_5 = '0000:0000:0000:0000:0000:0000:0000:0000';
        $case_6 = '2001:0000:0000:ab80:2390:0000:0000:000a';
        $case_7 = '2001:db8:a:bac:8099:d:f:9';
        $case_8 = '2001:db8:0:0:f:0:0:0';
        $exp_1 = '::1';
        $exp_2 = '2001:db8::ff00:42:8329';
        $exp_3 = '2001:0:0:acad::1';
        $exp_4 = '2001:db8::ff00:42:8329';
        $exp_5 = '::';
        $exp_6 = '2001:0:0:ab80:2390::a';
        $exp_7 = '2001:db8:a:bac:8099:d:f:9';
        $exp_8 = '2001:db8:0:0:f::';
        $this->assertEquals($exp_1, Toolbox::contractIpv6($case_1));
        $this->assertEquals($exp_2, Toolbox::contractIpv6($case_2));
        $this->assertEquals($exp_3, Toolbox::contractIpv6($case_3));
        $this->assertEquals($exp_4, Toolbox::contractIpv6($case_4));
        $this->assertEquals($exp_5, Toolbox::contractIpv6($case_5));
        $this->assertEquals($exp_6, Toolbox::contractIpv6($case_6));
        $this->assertEquals($exp_7, Toolbox::contractIpv6($case_7));
        $this->assertEquals($exp_8, Toolbox::contractIpv6($case_8));
    }

    /**
     *
     */
    public function testReverseIpv4()
    {
        $case_1 = '192.168.1.213';
        $exp_1 = '213.1.168.192.in-addr.arpa.';
        $this->assertEquals($exp_1, Toolbox::reverseIpv4($case_1));
    }

    /**
     *
     */
    public function testReverseIpv6()
    {
        $case_1 = '2001:db8::567:89ab';
        $case_2 = '8007:ea:19';
        $exp_1 = 'b.a.9.8.7.6.5.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.8.b.d.0.1.0.0.2.ip6.arpa.';
        $exp_2 = '9.1.0.0.a.e.0.0.7.0.0.8.ip6.arpa.';
        $this->assertEquals($exp_1, Toolbox::reverseIpv6($case_1));
        $this->assertEquals($exp_2, Toolbox::reverseIpv6($case_2));
    }
}