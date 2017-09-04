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


class TxtRdata implements RdataInterface
{
    use RdataTrait;
    const TYPE = 'TXT';
    /**
     * @var string
     */
    private $text;

    /**
     * @param $text
     */
    public function setText(string $text)
    {
        $this->text = addslashes($text);
    }

    public function getText(): string
    {
        return stripslashes($this->text);
    }

    /**
     * {@inheritdoc}
     */
    public function output(): string
    {
        return '"' . $this->text . '"';
    }
}