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

namespace App\Models\DNS\Rdata;

use App\Models\DNS\ResourceRecord;

/**
 * Class LocRdata.
 *
 * Mechanism to allow the DNS to carry location
 * information about hosts, networks, and subnets.
 *
 * @link http://tools.ietf.org/html/rfc1876
 */
class LocRdata implements RdataInterface, FormatTableInterface
{
    use RdataTrait, FormatTableTrait;
    const TYPE = 'LOC';
    const LATITUDE = 'LATITUDE';
    const LONGITUDE = 'LONGITUDE';
    const FORMAT_DECIMAL = 'DECIMAL';
    const FORMAT_DMS = 'DMS';
    /**
     * @var float
     */
    private $latitude;
    /**
     * @var float
     */
    private $longitude;
    /**
     * @var float
     */
    private $altitude = 0.0;
    /**
     * @var float
     */
    private $size = 1.0;
    /**
     * @var float
     */
    private $horizontalPrecision = 10000.0;
    /**
     * @var float
     */
    private $verticalPrecision = 10.0;

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = (double)$latitude;
    }

    /**
     * @param string $format
     *
     * @return float|string
     */
    public function getLatitude(string $format = self::FORMAT_DECIMAL)
    {
        if ($format === self::FORMAT_DMS) {
            return $this->toDms($this->latitude, self::LATITUDE);
        }
        return $this->latitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = (double)$longitude;
    }

    /**
     * @param string $format
     *
     * @return float|string
     */
    public function getLongitude($format = self::FORMAT_DECIMAL)
    {
        if ($format === self::FORMAT_DMS) {
            return $this->toDms($this->longitude, self::LONGITUDE);
        }
        return $this->longitude;
    }

    /**
     * @param float $altitude
     *
     * @throws \OutOfRangeException
     */
    public function setAltitude(float $altitude)
    {
        if ($altitude < -100000.00 || $altitude > 42849672.95) {
            throw new \OutOfRangeException('The altitude must be on [-100000.00, 42849672.95].');
        }
        $this->altitude = (double)$altitude;
    }

    /**
     * @return float
     */
    public function getAltitude(): float
    {
        return $this->altitude;
    }

    /**
     * @param float $horizontalPrecision
     *
     * @throws \OutOfRangeException
     */
    public function setHorizontalPrecision(float $horizontalPrecision)
    {
        if ($horizontalPrecision < 0 || $horizontalPrecision > 90000000.0) {
            throw new \OutOfRangeException('The horizontal precision must be on [0, 90000000.0].');
        }
        $this->horizontalPrecision = (double)$horizontalPrecision;
    }

    /**
     * @return float
     */
    public function getHorizontalPrecision(): float
    {
        return $this->horizontalPrecision;
    }

    /**
     * @param float $size
     *
     * @throws \OutOfRangeException
     */
    public function setSize(float $size)
    {
        if ($size < 0 || $size > 90000000.0) {
            throw new \OutOfRangeException('The size must be on [0, 90000000.0].');
        }
        $this->size = (double)$size;
    }

    /**
     * @return float
     */
    public function getSize(): float
    {
        return $this->size;
    }

    /**
     * @param float $verticalPrecision
     *
     * @throws \OutOfRangeException
     */
    public function setVerticalPrecision(float $verticalPrecision)
    {
        if ($verticalPrecision < 0 || $verticalPrecision > 90000000.0) {
            throw new \OutOfRangeException('The vertical precision must be on [0, 90000000.0].');
        }
        $this->verticalPrecision = $verticalPrecision;
    }

    /**
     * @return float
     */
    public function getVerticalPrecision(): float
    {
        return $this->verticalPrecision;
    }

    /**
     * {@inheritdoc}
     */
    public function output(): string
    {
        return sprintf(
            '%s %s %.2fm %.2fm %.2fm %.2fm',
            $this->getLatitude(self::FORMAT_DMS),
            $this->getLongitude(self::FORMAT_DMS),
            $this->altitude,
            $this->size,
            $this->horizontalPrecision,
            $this->verticalPrecision
        );
    }

    /**
     * {@inheritdoc}
     */
    public function outputFormatted(): string
    {
        return ResourceRecord::MULTILINE_BEGIN . PHP_EOL .
            $this->makeLine($this->getLatitude(self::FORMAT_DMS), 'LATITUDE') .
            $this->makeLine($this->getLongitude(self::FORMAT_DMS), 'LONGITUDE') .
            $this->makeLine(sprintf('%.2fm', $this->altitude), 'ALTITUDE') .
            $this->makeLine(sprintf('%.2fm', $this->size), 'SIZE') .
            $this->makeLine(sprintf('%.2fm', $this->horizontalPrecision), 'HORIZONTAL PRECISION') .
            $this->makeLine(sprintf('%.2fm', $this->verticalPrecision), 'VERTICAL PRECISION') .
            str_repeat(' ', $this->padding) . ResourceRecord::MULTILINE_END;
    }

    /**
     * Determines the longest variable.
     *
     * @return int
     */
    public function longestVarLength(): int
    {
        $l = 0;
        foreach ([
                     $this->getLatitude(self::FORMAT_DMS),
                     $this->getLongitude(self::FORMAT_DMS),
                     sprintf('%.2fm', $this->altitude),
                     sprintf('%.2fm', $this->size),
                     sprintf('%.2fm', $this->horizontalPrecision),
                     sprintf('%.2fm', $this->verticalPrecision),
                 ] as $var) {
            $l = ($l < strlen($var)) ? strlen($var) : $l;
        }
        return $l;
    }

    /**
     * Determine the degree minute seconds value from decimal.
     *
     * @param        $decimal
     * @param string $axis
     *
     * @return string
     */
    private function toDms(float $decimal, string $axis = self::LATITUDE): string
    {
        $d = (int)floor(abs($decimal));
        $m = (int)floor((abs($decimal) - $d) * 60);
        $s = ((abs($decimal) - $d) * 60 - $m) * 60;
        if ($axis === self::LATITUDE) {
            $h = ($decimal < 0) ? 'S' : 'N';
        } else {
            $h = ($decimal < 0) ? 'W' : 'E';
        }
        return sprintf('%d %d %.3f %s', $d, $m, $s, $h);
    }
}