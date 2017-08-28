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
 * @author      Paco Orozco <paco@pacoorozco.info>
 * @copyright   2017 Paco Orozco
 * @license     GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 * @link        https://github.com/pacoorozco/probind
 */

use App\DNSZoneFileParser;

class FileDNSParserUnitTest extends TestCase
{
    protected $fileContents = '
; <<>> DiG 9.10.6 <<>> axfr domain.local
;; global options: +cmd
domain.local.              172800  IN      SOA     dns1.domain.com. hostmaster.domain.local. 2017082401 1800 900 1814400 7200
domain.local.              3600    IN      TXT     "MS=ms12345678"
domain.local.              172800  IN      NAPTR   30 0 "s" "SIP+D2U" "" _sip._udp.domain.local.
domain.local.              3600  IN      MX      10 mx1.domain-ext.local.
domain.local.              3600  IN      MX      10 mx2.domain-ext.local.
domain.local.              172800  IN      NS      dns1.domain.com.
domain.local.              172800  IN      NS      dns2.domain.com.
_sip._udp.domain.local.    3600    IN      SRV     0 0 5060 montsec.domain-ext.local.
ad.domain.local.           172800  IN      NS      dns3.domain.com.
ad.domain.local.           172800  IN      NS      dns2.domain.com.
picaestats.domain.local.   172800  IN      CNAME   contraix.domain.local.
montsant.ad.domain.local.  172800  IN      A       10.11.197.54
;; Query time: 2 msec
;; SERVER: 10.11.2.3#53(10.11.2.3)
;; WHEN: Sat Aug 26 08:30:21 CEST 2017
;; XFR size: 16 records (messages 1, bytes 103)
';
    protected $expectedRecords = [

        [
            'name'  => 'domain.local.',
            'ttl'   => 172800,
            'class' => 'IN',
            'type'  => 'SOA',
            'data'  => 'dns1.domain.com. hostmaster.domain.local. 2017082401 1800 900 1814400 7200',
        ],
        [
            'name'  => 'domain.local.',
            'ttl'   => 3600,
            'class' => 'IN',
            'type'  => 'TXT',
            'data'  => '"MS=ms12345678"',
        ],
        [
            'name'  => 'domain.local.',
            'ttl'   => 172800,
            'class' => 'IN',
            'type'  => 'NAPTR',
            'data'  => '30 0 "s" "SIP+D2U" "" _sip._udp.domain.local.',
        ],
        [
            'name'    => 'domain.local.',
            'ttl'     => 3600,
            'class'   => 'IN',
            'type'    => 'MX',
            'data'    => '10 mx1.domain-ext.local.',
        ],
        [
            'name'    => 'domain.local.',
            'ttl'     => 3600,
            'class'   => 'IN',
            'type'    => 'MX',
            'data'    => '10 mx2.domain-ext.local.',
        ],
        [
            'name'  => 'domain.local.',
            'ttl'   => 172800,
            'class' => 'IN',
            'type'  => 'NS',
            'data'  => 'dns1.domain.com.',
        ],
        [
            'name'  => 'domain.local.',
            'ttl'   => 172800,
            'class' => 'IN',
            'type'  => 'NS',
            'data'  => 'dns2.domain.com.',
        ],
        [
            'name'  => '_sip._udp.domain.local.',
            'ttl'   => 3600,
            'class' => 'IN',
            'type'  => 'SRV',
            'data'  => '0 0 5060 montsec.domain-ext.local.',
        ],
        [
            'name'  => 'ad.domain.local.',
            'ttl'   => 172800,
            'class' => 'IN',
            'type'  => 'NS',
            'data'  => 'dns3.domain.com.',
        ],
        [
            'name'  => 'ad.domain.local.',
            'ttl'   => 172800,
            'class' => 'IN',
            'type'  => 'NS',
            'data'  => 'dns2.domain.com.',
        ],
        [
            'name'  => 'picaestats.domain.local.',
            'ttl'   => 172800,
            'class' => 'IN',
            'type'  => 'CNAME',
            'data'  => 'contraix.domain.local.',
        ],
        [
            'name'  => 'montsant.ad.domain.local.',
            'ttl'   => 172800,
            'class' => 'IN',
            'type'  => 'A',
            'data'  => '10.11.197.54',
        ],

    ];

    /**
     * Test RFC 1033 file parser.
     */
    public function testParseZoneFile()
    {
        // Mock Filesystem with $this->fileContents.
        File::shouldReceive('get')
            ->with('location')
            ->andReturn($this->fileContents);

        $zoneContents = new DNSZoneFileParser();
        $zoneContents->parseZoneFile('location');

        $records = $zoneContents->getRecords();
        $expectedRecords = $this->expectedRecords;

        $this->assertEquals($expectedRecords, $records);
    }
}
