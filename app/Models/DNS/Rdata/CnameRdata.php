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

class CnameRdata implements RdataInterface
{
    use RdataTrait;
    const TYPE = 'CNAME';
    /**
     * @var string
     */
    protected $target;

    /**
     * @param $target
     *
     * @throws RdataException
     */
    public function setTarget(string $target)
    {
        if (!Validator::validateFqdn($target, false)) {
            throw new RdataException(sprintf('The target "%s" is not a Fully Qualified Domain Name', $target));
        }
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * {@inheritdoc}
     */
    public function output(): string
    {
        return $this->target;
    }
}