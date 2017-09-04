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

use App\Models\DNS\ResourceRecord;
use App\Models\DNS\Rdata\Factory;
use App\Models\DNS\Classes;
use App\Models\DNS\Zone;

abstract class DNSTestCase extends \TestCase
{
    const PHP_ENV_CHECKZONE_PATH = 'CHECKZONE_PATH';
    const PHP_ENV_PRINT_TEST_ZONE = 'PRINT_TEST_ZONE';
    /**
     * @var string
     */
    protected $expected = <<< 'DNS'
$ORIGIN example.com.
$TTL 3600
@ IN SOA example.com. postmaster.example.com. 2015050801 3600 14400 604800 3600
@ 14400 IN NS ns1.example.net.au.
@ 14400 IN NS ns2.example.net.au.
subdomain.au A 192.168.1.2; This is a local ip.
ipv6domain 3600 IN AAAA ::1; This is an IPv6 domain.
canberra IN LOC 35 18 27.000 S 149 7 27.840 E 500.00m 20.12m 200.30m 300.10m; This is Canberra
bar.example.com. IN DNAME foo.example.com.
@ MX 30 mail-gw3.example.net.
@ MX 10 mail-gw1.example.net.
@ MX 20 mail-gw2.example.net.
alias CNAME subdomain.au.example.com.
example.net. IN TXT "v=spf1 ip4:192.0.2.0/24 ip4:198.51.100.123 a -all"
@ IN HINFO "2.7GHz" "Ubuntu 12.04"
DNS;

    /**
     * Get an environment variable.
     *
     * @param string $varname
     *
     * @return mixed
     */
    protected function getEnvVariable($varname)
    {
        if (false !== $var = getenv($varname)) {
            return $var;
        }
        return false;
    }

    /**
     * Print out a block of text.
     *
     * @param string $text
     * @param string $title
     */
    protected function printBlock($text, $title = '')
    {
        $output =
            PHP_EOL . PHP_EOL .
            '=====================================' . $title . '=====================================' .
            PHP_EOL .
            $text .
            PHP_EOL .
            '=====================================' . $title . '=====================================' .
            PHP_EOL . PHP_EOL;
        print $output;
    }

    /**
     * @return Zone
     */
    protected function buildTestZone()
    {
        $soa = new ResourceRecord();
        $soa->setClass('IN');
        $soa->setName('@');
        $soa->setRdata(Factory::Soa(
            'example.com.',
            'postmaster.example.com.',
            2015050801,
            3600,
            14400,
            604800,
            3600
        ));
        $ns1 = new ResourceRecord();
        $ns1->setClass('IN');
        $ns1->setName('@');
        $ns1->setTtl(14400);
        $ns1->setRdata(Factory::Ns('ns1.example.net.au.'));
        $ns2 = new ResourceRecord();
        $ns2->setClass('IN');
        $ns2->setName('@');
        $ns2->setTtl(14400);
        $ns2->setRdata(Factory::Ns('ns2.example.net.au.'));
        $a_record = new ResourceRecord();
        $a_record->setName('subdomain.au');
        $a_record->setRdata(Factory::A('192.168.1.2'));
        $a_record->setComment('This is a local ip.');
        $cname = new ResourceRecord();
        $cname->setName('alias');
        $cname->setRdata(Factory::Cname('subdomain.au.example.com.'));
        $aaaa = new ResourceRecord(
            'ipv6domain',
            Factory::Aaaa('::1'),
            3600,
            Classes::INTERNET,
            'This is an IPv6 domain.'
        );
        $mx1 = new ResourceRecord();
        $mx1->setName('@');
        $mx1->setRdata(Factory::Mx(10, 'mail-gw1.example.net.'));
        $mx2 = new ResourceRecord();
        $mx2->setName('@');
        $mx2->setRdata(Factory::Mx(20, 'mail-gw2.example.net.'));
        $mx3 = new ResourceRecord();
        $mx3->setName('@');
        $mx3->setRdata(Factory::Mx(30, 'mail-gw3.example.net.'));
        $txt = new ResourceRecord();
        $txt->setName('example.net.');
        $txt->setRdata(Factory::txt('v=spf1 ip4:192.0.2.0/24 ip4:198.51.100.123 a -all'));
        $txt->setClass(Classes::INTERNET);
        $loc = new ResourceRecord();
        $loc->setName('canberra');
        $loc->setRdata(Factory::Loc(
            -35.3075,   //Lat
            149.1244,   //Lon
            500,        //Alt
            20.12,      //Size
            200.3,      //HP
            300.1       //VP
        ));
        $loc->setComment('This is Canberra');
        $loc->setClass(Classes::INTERNET);
        $dname = new ResourceRecord();
        $dname->setName('bar.example.com.');
        $dname->setClass(Classes::INTERNET);
        $dname->setRdata(Factory::Dname('foo.example.com.'));
        $hinfo = new ResourceRecord();
        $hinfo->setName('@');
        $hinfo->setClass(Classes::INTERNET);
        $hinfo->setRdata(Factory::Hinfo('2.7GHz', 'Ubuntu 12.04'));
        return new Zone('example.com.', 3600, [
            $soa,
            $ns1,
            $ns2,
            $a_record,
            $aaaa,
            $loc,
            $dname,
            $mx3,
            $mx1,
            $mx2,
            $cname,
            $txt,
            $hinfo,
        ]);
    }
}