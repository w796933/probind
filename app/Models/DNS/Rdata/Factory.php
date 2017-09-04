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

class Factory
{
    /**
     * Create a new AAAA R-Data object.
     *
     * @param string $address
     *
     * @return AaaaRdata
     */
    public static function Aaaa(string $address): AaaaRdata
    {
        $rdata = new AaaaRdata();
        $rdata->setAddress($address);
        return $rdata;
    }

    /**
     * Create a new A R-Data object.
     *
     * @param string $address
     *
     * @return ARdata
     */
    public static function A(string $address): ARdata
    {
        $rdata = new ARdata();
        $rdata->setAddress($address);
        return $rdata;
    }

    /**
     * Create a new CNAME object.
     *
     * @param string $cname
     *
     * @return CnameRdata
     */
    public static function Cname(string $cname): CnameRdata
    {
        $rdata = new CnameRdata();
        $rdata->setTarget($cname);
        return $rdata;
    }

    /**
     * @param string $cpu
     * @param string $os
     *
     * @return HinfoRdata
     */
    public static function Hinfo(string $cpu, string $os): HinfoRdata
    {
        $rdata = new HinfoRdata();
        $rdata->setCpu($cpu);
        $rdata->setOs($os);
        return $rdata;
    }

    /**
     * @param int    $preference
     * @param string $exchange
     *
     * @return MxRdata
     */
    public static function Mx(int $preference, string $exchange): MxRdata
    {
        $rdata = new MxRdata();
        $rdata->setPreference($preference);
        $rdata->setExchange($exchange);
        return $rdata;
    }

    /**
     * @param string $mname
     * @param string $rname
     * @param int    $serial
     * @param int    $refresh
     * @param int    $retry
     * @param int    $expire
     * @param int    $minimum
     *
     * @return SoaRdata
     */
    public static function Soa(string $mname, string $rname, int $serial, int $refresh, int $retry, int $expire, int $minimum): SoaRdata
    {
        $rdata = new SoaRdata();
        $rdata->setMname($mname);
        $rdata->setRname($rname);
        $rdata->setSerial($serial);
        $rdata->setRefresh($refresh);
        $rdata->setRetry($retry);
        $rdata->setExpire($expire);
        $rdata->setMinimum($minimum);
        return $rdata;
    }

    /**
     * @param string $nsdname
     *
     * @return NsRdata
     */
    public static function Ns(string $nsdname): NsRdata
    {
        $rdata = new NsRdata();
        $rdata->setTarget($nsdname);
        return $rdata;
    }

    /**
     * @param string $text
     *
     * @return TxtRdata
     */
    public static function txt(string $text): TxtRdata
    {
        $rdata = new TxtRdata();
        $rdata->setText($text);
        return $rdata;
    }

    /**
     * @param string $target
     *
     * @return DnameRdata
     */
    public static function Dname(string $target): DnameRdata
    {
        $rdata = new DnameRdata();
        $rdata->setTarget($target);
        return $rdata;
    }

    /**
     * @param       $lat
     * @param       $lon
     * @param float $alt
     * @param float $size
     * @param float $hp
     * @param float $vp
     *
     * @return LocRdata
     */
    public static function Loc(float $lat, float $lon, float $alt = 0.0, float $size = 1.0, float $hp = 10000.0, float $vp = 10.0): LocRdata
    {
        $rdata = new LocRdata();
        $rdata->setLatitude($lat);
        $rdata->setLongitude($lon);
        $rdata->setAltitude($alt);
        $rdata->setSize($size);
        $rdata->setHorizontalPrecision($hp);
        $rdata->setVerticalPrecision($vp);
        return $rdata;
    }

    /**
     * @param string $target
     *
     * @return PtrRdata
     */
    public static function Ptr(string $target): PtrRdata
    {
        $rdata = new PtrRdata();
        $rdata->setTarget($target);
        return $rdata;
    }
}