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

class AaaaRdata extends ARdata
{
    const TYPE = 'AAAA';

    /**
     * @param string $address
     *
     * @throws RdataException
     */
    public function setAddress(string $address)
    {
        if (!Validator::validateIpv6Address($address)) {
            throw new RdataException(sprintf('Address "%s" is not a valid IPv6 address', $address));
        }
        $this->address = $address;
    }
}