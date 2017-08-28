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

namespace App;

use Exception;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class DNSZoneFileParser
{
    /**
     * Contains all the records in this zone.
     *
     * An unindexed array of Resource Records (RR's) for this zone. Each item is a separate array representing a RR.
     *
     * Each RR item is an array:
     *
     * $record = [
     *  'name'      => 'sub.domain',
     *  'ttl'       => 7200,
     *  'class'     => 'IN',
     *  'type'      => 'MX',
     *  'data'      => '10 10.10.10.1',
     * ];
     *
     * @var array
     */
    private $records = array();

    /**
     * Zone data of the loaded zone.
     *
     * This contains all the relevant data stored in the SOA (Start of Authority) record.
     * It's stored in an associative array, that should be pretty self-explaining.
     *
     * $zoneData = [
     *       'domain' => 'example.com.',
     *       'mname' => 'ns1.example.com.',
     *       'rname' => 'hostmaster.example.com.',
     *       'serial' => '204041514',
     *       'refresh' => '14400',
     *       'retry' => '1800',
     *       'expire' => '86400',
     *       'negative_ttl' => '10800',
     *       'default_ttl' => '16400',
     *   ];
     *
     * @var array
     */
    private $zoneData = [
        'domain'       => null,
        'mname'        => null,
        'rname'        => null,
        'serial'       => null,
        'refresh'      => null,
        'retry'        => null,
        'expire'       => null,
        'negative_ttl' => null,
        'default_ttl'  => null,
    ];

    public function parseZoneFile(string $location) {
        return $this->readZoneFileFromFileSystem($location);
    }

    public function readZoneFileFromFileSystem(string $location)
    {
        try {
            $zoneContents = File::get($location);
        } catch (\Exception $e) {
            throw new FileNotFoundException('Unable to read file: ' . $location);
        }

        return $this->processZoneFile($zoneContents);
    }

    public function getRecords()
    {
        return $this->records;
    }

    public function processZoneFile(string $zoneContents)
    {
        $zoneContents = $this->filterZoneContent($zoneContents);

        // We will parse contents line by line.
        $zoneContents = explode(PHP_EOL, $zoneContents);
        $count = 0;
        foreach ($zoneContents as $line) {
            // Remove multiple spaces and tabs.
            $line = preg_replace('/\s+/', ' ', $line);
            if (!empty($line)) {
                $record = $this->parseResourceRecord($line);
                $count++;
                $this->records[] = $record;
            }
        }
        return $count;
    }

    /**
     * Remove comments Zone contents.
     *
     * @param string $content
     *
     * @return string
     */
    private function filterZoneContent(string $content): string
    {
        // A semicolon (';') starts a comment; the remainder of the line is ignored.
        return preg_replace('/(;.*)$/m', '', $content);


    }

    /**
     * Parses a (Resource Record) into an array
     *
     * @param string $line the RR line to be parsed.
     *
     * @return array  array of RR info.
     */
    private function parseResourceRecord(string $line): array
    {
        $items = explode(' ', $line, 5);

        $record = [];
        $record['name'] = $items[0];
        $record['ttl'] = $items[1];
        $record['class'] = $items[2];
        $record['type'] = $items[3];
        $record['data'] = $items[4];

        return $record;
    }


}