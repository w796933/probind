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

class MxRdata implements RdataInterface
{
    use RdataTrait;
    const TYPE = 'MX';
    /**
     * @var int
     */
    private $preference;
    /**
     * @var string
     */
    private $exchange;

    /**
     * @param string $exchange
     *
     * @throws RdataException
     */
    public function setExchange(string $exchange)
    {
        if (!Validator::validateFqdn($exchange)) {
            throw new RdataException(sprintf('The exchange "%s" is not a Fully Qualified Domain Name', $exchange));
        }
        $this->exchange = $exchange;
    }

    /**
     * @return string
     */
    public function getExchange(): string
    {
        return $this->exchange;
    }

    /**
     * @param int $preference
     */
    public function setPreference(int $preference)
    {
        $this->preference = (int)$preference;
    }

    /**
     * @return int
     */
    public function getPreference(): int
    {
        return $this->preference;
    }

    /**
     * {@inheritdoc}
     */
    public function output(): string
    {
        return $this->preference . ' ' . $this->exchange;
    }
}