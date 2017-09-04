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

use App\Models\DNS\Validator;
use App\Models\DNS\ResourceRecord;

/**
 * @link http://www.ietf.org/rfc/rfc1035.text
 */
class SoaRdata implements RdataInterface, FormatTableInterface
{
    use RdataTrait, FormatTableTrait;
    const TYPE = 'SOA';
    /**
     * The <domain-name> of the name server that was the
     * original or primary source of data for this zone.
     *
     * @var string
     */
    private $mname;
    /**
     * A <domain-name> which specifies the mailbox of the
     * person responsible for this zone.
     *
     * @var string
     */
    private $rname;
    /**
     * The unsigned 32 bit version number of the original copy
     * of the zone.
     *
     * @var int
     */
    private $serial;
    /**
     * A 32 bit time interval before the zone should be
     * refreshed.
     *
     * @var int
     */
    private $refresh;
    /**
     * A 32 bit time interval that should elapse before a
     * failed refresh should be retried.
     *
     * @var int
     */
    private $retry;
    /**
     * A 32 bit time value that specifies the upper limit on
     * the time interval that can elapse before the zone is no
     * longer authoritative.
     *
     * @var int
     */
    private $expire;
    /**
     * The unsigned 32 bit minimum TTL field that should be
     * exported with any RR from this zone.
     *
     * @var int
     */
    private $minimum;

    /**
     * @param $expire
     */
    public function setExpire(int $expire)
    {
        $this->expire = (int)$expire;
    }

    /**
     * @return int
     */
    public function getExpire(): int
    {
        return $this->expire;
    }

    /**
     * @param int $minimum
     */
    public function setMinimum(int $minimum)
    {
        $this->minimum = (int)$minimum;
    }

    /**
     * @return int
     */
    public function getMinimum(): int
    {
        return $this->minimum;
    }

    /**
     * @param $mname
     *
     * @throws RdataException
     */
    public function setMname(string $mname)
    {
        if (!Validator::validateFqdn($mname)) {
            throw new RdataException(sprintf('MName "%s" is not a Fully Qualified Domain Name', $mname));
        }
        $this->mname = $mname;
    }

    /**
     * @return string
     */
    public function getMname(): string
    {
        return $this->mname;
    }

    /**
     * @param $refresh
     */
    public function setRefresh(int $refresh)
    {
        $this->refresh = (int)$refresh;
    }

    /**
     * @return int
     */
    public function getRefresh(): int
    {
        return $this->refresh;
    }

    /**
     * @param $retry
     */
    public function setRetry(int $retry)
    {
        $this->retry = (int)$retry;
    }

    /**
     * @return int
     */
    public function getRetry(): int
    {
        return $this->retry;
    }

    /**
     * @param $rname
     *
     * @throws RdataException
     */
    public function setRname(string $rname)
    {
        if (!Validator::validateFqdn($rname)) {
            throw new RdataException(sprintf('RName "%s" is not a Fully Qualified Domain Name', $rname));
        }
        $this->rname = $rname;
    }

    /**
     * @return string
     */
    public function getRname(): string
    {
        return $this->rname;
    }

    /**
     * @param int $serial
     */
    public function setSerial(int $serial)
    {
        $this->serial = (int)$serial;
    }

    /**
     * @return int
     */
    public function getSerial(): int
    {
        return $this->serial;
    }

    /**
     * {@inheritdoc}
     */
    public function output(): string
    {
        return sprintf(
            '%s %s %s %s %s %s %s',
            $this->mname,
            $this->rname,
            $this->serial,
            $this->refresh,
            $this->retry,
            $this->expire,
            $this->minimum
        );
    }

    /**
     * {@inheritdoc}
     */
    public function outputFormatted(): string
    {
        return ResourceRecord::MULTILINE_BEGIN . PHP_EOL .
            $this->makeLine($this->getMname(), 'MNAME') .
            $this->makeLine($this->getRname(), 'RNAME') .
            $this->makeLine($this->getSerial(), 'SERIAL') .
            $this->makeLine($this->getRefresh(), 'REFRESH') .
            $this->makeLine($this->getRetry(), 'RETRY') .
            $this->makeLine($this->getExpire(), 'EXPIRE') .
            $this->makeLine($this->getMinimum(), 'MINIMUM') .
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
                     $this->getMname(),
                     $this->getRname(),
                     $this->getSerial(),
                     $this->getRefresh(),
                     $this->getRetry(),
                     $this->getExpire(),
                     $this->getMinimum(),
                 ] as $var) {
            $l = ($l < strlen($var)) ? strlen($var) : $l;
        }
        return $l;
    }
}