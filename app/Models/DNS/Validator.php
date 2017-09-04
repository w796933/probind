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


namespace App\Models\DNS;


class Validator
{
    const ZONE_OKAY = 0;

    const ZONE_NO_SOA = 1;

    const ZONE_TOO_MANY_SOA = 2;

    const ZONE_NO_NS = 4;

    const ZONE_NO_CLASS = 8;

    const ZONE_TOO_MANY_CLASSES = 16;

    /**
     * Validates if $string is suitable as an RR name.
     *
     * @param string $string
     * @param bool   $mustHaveTrailingDot
     *
     * @return bool
     */
    public static function rrName(string $string, bool $mustHaveTrailingDot = false): bool
    {
        if ($string === '@' ||
            self::reverseIpv4($string) ||
            self::reverseIpv6($string)
        ) {
            return true;
        }

        if ($string === '*.') {
            return false;
        }

        $parts = explode('.', strtolower($string));

        if ('' !== end($parts) && $mustHaveTrailingDot) {
            return false;
        }

        if ('' === end($parts)) {
            array_pop($parts);
        }

        foreach ($parts as $i => $part) {
            //Does the string begin with a non alphanumeric char?
            if (1 === preg_match('/^[^a-z0-9]/', $part)) {
                if ('*' === $part && 0 === $i) {
                    continue;
                }

                return false;
            }

            if (1 !== preg_match('/^[a-z0-9_\-]+$/i', $part)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates a reverse IPv4 address. Ensures that all octets are in the range [0-255].
     *
     * @param string $address
     *
     * @return bool
     */
    public static function reverseIpv4(string $address): bool
    {
        $pattern = '/^((?:[0-9]+\.){1,4})in\-addr\.arpa\.$/i';

        if (1 !== preg_match($pattern, $address, $matches)) {
            return false;
        }

        $octets = explode('.', $matches[1]);
        array_pop($octets); //Remove the last decimal from the array

        foreach ($octets as $octet) {
            if ((int)$octet > 255) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates a reverse IPv6 address.
     *
     * @param string $address
     *
     * @return bool
     */
    public static function reverseIpv6(string $address): bool
    {
        $pattern = '/^(?:[0-9a-f]\.){1,32}ip6\.arpa\.$/i';

        return 1 === preg_match($pattern, $address);
    }

    /**
     * Validate the string as a Fully Qualified Domain Name.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function fqdn(string $string): bool
    {
        $parts = explode('.', strtolower($string));

        //Is there are trailing dot?
        if ('' !== end($parts)) {
            return false;
        }

        array_pop($parts);

        foreach ($parts as $part) {
            //Does the string begin with a non alpha char?
            if (1 === preg_match('/^[^a-z]/i', $part)) {
                return false;
            }

            if (1 !== preg_match('/^[a-z0-9_\-]+$/i', $part)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $string
     * @param bool   $trailingDot Require trailing dot
     *
     * @return bool
     */
    public static function validateFqdn(string $string, bool $trailingDot = true): bool
    {
        if ($string === '@') {
            return true;
        }

        if ($string === '*.') {
            return false;
        }

        $parts = explode('.', strtolower($string));
        $hasTrailingDot = (end($parts) === '');

        if ($trailingDot && !$hasTrailingDot) {
            return false;
        }

        if ($hasTrailingDot) {
            array_pop($parts);
        }

        foreach ($parts as $i => $part) {
            //Does the string begin with a non alpha char?
            if (1 === preg_match('/^[^a-z]/', $part)) {
                if ('*' === $part && 0 === $i) {
                    continue;
                }

                return false;
            }

            if (1 !== preg_match('/^[a-z0-9_\-]+$/', $part)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates an IPv4 Address.
     *
     * @static
     *
     * @param string $ipAddress
     *
     * @return bool
     */
    public static function validateIpv4Address(string $ipAddress): bool
    {
        return (bool)filter_var($ipAddress, FILTER_VALIDATE_IP, [
            'flags' => FILTER_FLAG_IPV4,
        ]);
    }

    /**
     * Validates an IPv6 Address.
     *
     * @static
     *
     * @param string $ipAddress
     *
     * @return bool
     */
    public static function validateIpv6Address(string $ipAddress): bool
    {
        return (bool)filter_var($ipAddress, FILTER_VALIDATE_IP, [
            'flags' => FILTER_FLAG_IPV6,
        ]);
    }

    /**
     * Validates an IPv4 or IPv6 address.
     *
     * @static
     *
     * @param $ipAddress
     *
     * @return bool
     */
    public static function validateIpAddress(string $ipAddress): bool
    {
        return (bool)filter_var($ipAddress, FILTER_VALIDATE_IP);
    }

    /**
     * Validates a zone file.
     *
     * @deprecated
     *
     * @param string $zonename
     * @param string $directory
     * @param string $named_checkzonePath
     *
     * @return bool
     */
    public static function validateZoneFile(
        string $zonename,
        string $directory,
        string $named_checkzonePath = 'named-checkzone'
    ): bool {
        $command = sprintf('%s -q %s %s', $named_checkzonePath, $zonename, $directory);
        exec($command, $output, $exit_status);

        return $exit_status === 0;
    }

    /**
     * Validates that the zone meets
     * RFC-1035 especially that:
     *   1) 5.2.1 All RRs in the file should be of the same class.
     *   2) 5.2.2 Exactly one SOA RR should be present at the top of the zone.
     *   3) There is at least one NS record.
     *
     * @deprecated
     *
     * @param ZoneInterface $zone
     *
     * @throws ZoneException
     *
     * @return bool
     */
    public static function validate(ZoneInterface $zone): bool
    {
        $n_soa = self::countResourceRecords($zone, SoaRdata::TYPE);
        $n_ns = self::countResourceRecords($zone, NsRdata::TYPE);
        $classes = [];

        foreach ($zone->getResourceRecords() as $rr) {
            if (null !== $rr->getClass()) {
                $classes[$rr->getClass()] = null;
            }
        }

        $n_class = count($classes);

        if (1 !== $n_soa) {
            throw new ZoneException(sprintf('There must be exactly one SOA record, %s given.', $n_soa));
        }

        if ($n_ns < 1) {
            throw new ZoneException(sprintf('There must be at least one NS record, %s given.', $n_ns));
        }

        if (1 !== $n_class) {
            throw new ZoneException(sprintf('There must be exactly one type of class, %s given.', $n_class));
        }

        return true;
    }

    /**
     * Counts the number of Resource Records of a particular type ($type) in a Zone.
     *
     * @param ZoneInterface $zone
     * @param null          $type The ResourceRecord type to be counted. If NULL, then the method will return
     *                            the total number of resource records.
     *
     * @return int The number of records to be counted.
     */
    public static function countResourceRecords(ZoneInterface $zone, $type = null): int
    {
        if (null === $type) {
            return count($zone->getResourceRecords());
        }

        $n = 0;

        foreach ($zone->getResourceRecords() as $rr) {
            /* @var $rr ResourceRecordInterface */
            if ($type === $rr->getRdata()->getType()) {
                $n += 1;
            }
        }

        return $n;
    }

    /**
     * Validates that the zone meets
     * RFC-1035 especially that:
     *   1) 5.2.1 All RRs in the file should be of the same class.
     *   2) 5.2.2 Exactly one SOA RR should be present at the top of the zone.
     *   3) There is at least one NS record.
     *
     * Return values are:
     *   - ZONE_NO_SOA
     *   - ZONE_TOO_MANY_SOA
     *   - ZONE_NO_NS
     *   - ZONE_NO_CLASS
     *   - ZONE_TOO_MANY_CLASSES
     *   - ZONE_OKAY
     *
     * You SHOULD compare these return values to the defined constants of this
     * class rather than against integers directly.
     *
     * @param ZoneInterface $zone
     *
     * @return integer
     */
    public static function zone(ZoneInterface $zone): int
    {
        $n_soa = self::countResourceRecords($zone, SoaRdata::TYPE);
        $n_ns = self::countResourceRecords($zone, NsRdata::TYPE);
        $classes = [];

        foreach ($zone->getResourceRecords() as $rr) {
            if (null !== $rr->getClass()) {
                $classes[$rr->getClass()] = null;
            }
        }

        $n_class = count($classes);

        if ($n_soa < 1) {
            return self::ZONE_NO_SOA;
        }

        if ($n_soa > 1) {
            return self::ZONE_TOO_MANY_SOA;
        }

        if ($n_ns < 1) {
            return self::ZONE_NO_NS;
        }

        if ($n_class < 1) {
            return self::ZONE_NO_CLASS;
        }

        if ($n_class > 1) {
            return self::ZONE_TOO_MANY_CLASSES;
        }

        return self::ZONE_OKAY;
    }
}