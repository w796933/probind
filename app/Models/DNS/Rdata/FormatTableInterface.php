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


/**
 * Interface FormatTableInterface.
 *
 * Indicates if there is a "nicer" way of outputting RData
 * so that it is more human readable
 */
interface FormatTableInterface
{
    /**
     * Set the amount of left padding on the output.
     *
     * @param int $padding
     */
    public function setPadding(int $padding);

    /**
     * Outputs the RData in a much more human readable way.
     *
     * @return string
     */
    public function outputFormatted(): string;
}