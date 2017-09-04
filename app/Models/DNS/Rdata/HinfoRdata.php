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


class HinfoRdata implements RdataInterface
{
    use RdataTrait;
    const TYPE = 'HINFO';
    /**
     * @var string
     */
    private $cpu;
    /**
     * @var string
     */
    private $os;

    /**
     * @param $cpu
     */
    public function setCpu(string $cpu)
    {
        $this->cpu = (string)$cpu;
    }

    /**
     * @return string
     */
    public function getCpu(): string
    {
        return $this->cpu;
    }

    /**
     * @param string $os
     */
    public function setOs(string $os)
    {
        $this->os = (string)$os;
    }

    /**
     * @return string
     */
    public function getOs(): string
    {
        return $this->os;
    }

    /**
     * {@inheritdoc}
     */
    public function output(): string
    {
        return sprintf('"%s" "%s"', $this->cpu, $this->os);
    }
}