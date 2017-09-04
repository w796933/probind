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

namespace App\Models\DNS;

class Classes
{
    const CHAOS = 'CH';
    const HESIOD = 'HS';
    const INTERNET = 'IN';
    /**
     * @var array
     */
    public static $classes = [
        self::CHAOS    => 'CHAOS',
        self::HESIOD   => 'Hesiod',
        self::INTERNET => 'Internet',
    ];

    /**
     * Determine if a class is valid.
     *
     * @param string $class
     *
     * @return bool
     */
    public static function isValid($class)
    {
        return array_key_exists($class, self::$classes);
    }
}