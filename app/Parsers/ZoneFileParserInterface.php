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
 * @author      Paco Orozco <paco@pacoorozco.info>
 * @copyright   2017 Paco Orozco
 * @license     GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 * @link        https://github.com/pacoorozco/probind
 */

namespace App\Parsers;

use Illuminate\Support\Collection;

/**
 * Interface ZoneFileParserInterface
 *
 * Transform a Zone file content into an array of Resource Records.
 *
 * @package App\Parsers
 */
interface ZoneFileParserInterface
{
    /**
     * Parse a file to get a Collection of resource records.
     *
     * @param string $location
     *
     * @return int
     */
    public function parseFile(string $location): int;

    /**
     * Get the resource records that has been parsed from file contents.
     * @return Collection
     */
    public function getRecords(): Collection;
}