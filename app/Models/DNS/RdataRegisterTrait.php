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

namespace App\Models\DNS;

use App\Models\DNS\Rdata\RdataInterface;

trait RdataRegisterTrait
{
    protected $rdataTypes = [
        Rdata\CnameRdata::TYPE => '\\App\\Models\\DNS\\Rdata\\CnameRdata',
        Rdata\DnameRdata::TYPE => '\\App\\Models\\DNS\\Rdata\\DnameRdata',
        Rdata\HinfoRdata::TYPE => '\\App\\Models\\DNS\\Rdata\\HinfoRdata',
        Rdata\AaaaRdata::TYPE  => '\\App\\Models\\DNS\\Rdata\\AaaaRdata',
        Rdata\SoaRdata::TYPE   => '\\App\\Models\\DNS\\Rdata\\SoaRdata',
        Rdata\LocRdata::TYPE   => '\\App\\Models\\DNS\\Rdata\\LocRdata',
        Rdata\PtrRdata::TYPE   => '\\App\\Models\\DNS\\Rdata\\PtrRdata',
        Rdata\TxtRdata::TYPE   => '\\App\\Models\\DNS\\Rdata\\TxtRdata',
        Rdata\NsRdata::TYPE    => '\\App\\Models\\DNS\\Rdata\\NsRdata',
        Rdata\MxRdata::TYPE    => '\\App\\Models\\DNS\\Rdata\\MxRdata',
        Rdata\ARdata::TYPE     => '\\App\\Models\\DNS\\Rdata\\ARdata',
    ];

    /**
     * @param string $type
     * @param string $fqcn
     *
     * @throws \InvalidArgumentException
     */
    public function registerRdataType(string $type, string $fqcn)
    {
        if (false === (new \ReflectionClass($fqcn))->implementsInterface('\\App\\Models\\DNS\\Rdata\\RdataInterface')) {
            throw new \InvalidArgumentException(sprintf(
                'The class "%s" is not an instance of Badcow\DNS\Rdata\RdataInterface',
                $fqcn
            ));
        }

        $this->rdataTypes[$type] = $fqcn;
    }

    /**
     * Removes an Rdata type.
     *
     * @param $type
     */
    public function removeRdataType(string $type)
    {
        if (!$this->hasRdataType($type)) {
            return;
        }

        unset($this->rdataTypes[$type]);
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public function hasRdataType(string $type): bool
    {
        return array_key_exists($type, $this->rdataTypes);
    }

    /**
     * @return array
     */
    public function getRegisteredTypes(): array
    {
        return array_keys($this->rdataTypes);
    }

    /**
     * Returns an Rdata instance based on the type.
     *
     * @param $type
     *
     * @return RdataInterface
     *
     * @throws \DomainException
     */
    protected function getNewRdataByType(string $type): RdataInterface
    {
        if (!$this->hasRdataType($type)) {
            throw new \DomainException(sprintf(
                'The Rdata type "%s" is not a registered type.',
                $type
            ));
        }

        return new $this->rdataTypes[$type]();
    }
}
