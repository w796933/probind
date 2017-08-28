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

use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;

class DNSZoneFileParser
{
    /**
     * Contains a Collection of records in this zone.
     *
     * Collection of Resource Records (RR's) for this zone. Each item is a separate array representing a RR.
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
    private $records;

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

    public function __construct()
    {
        $this->records = new Collection();
    }

    public function readZoneFromFileSystem(string $location): int
    {
        try {
            $zoneContents = File::get($location);
        } catch (\Exception $e) {
            throw new FileNotFoundException('Unable to read Zone file: ' . $location);
        }

        return $this->processZoneFile($zoneContents);
    }

    public function processZoneFile(string $zoneContents): int
    {
        // Remove comments from contents
        $zoneContents = $this->filterComments($zoneContents);

        // We will parse contents line by line.
        $zoneContents = explode(PHP_EOL, $zoneContents);
        foreach ($zoneContents as $line) {
            // Remove multiple spaces and tabs.
            $line = preg_replace('/\s+/', ' ', $line);
            if (!empty($line)) {
                $record = $this->parseResourceRecord($line);
                $this->records->push($record);
            }
        }

        return $this->records->count();
    }

    /**
     * Remove comments from Zone file contents
     *
     * - Comment lines start with a ';' character.
     *
     * @param string $content
     *
     * @return string
     */
    private function filterComments(string $content): string
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
        list($name, $ttl, $class, $type, $data) = explode(' ', $line, 5);

        return [
            'name'  => mb_strtolower($name),
            'ttl'   => (int)$ttl,
            'class' => mb_strtoupper($class),
            'type'  => mb_strtoupper($type),
            'data'  => $data,
        ];
    }

    public function getRecords(): Collection
    {
        return $this->records;
    }
}