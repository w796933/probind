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
 * Class DnameRdata.
 *
 * The DNAME record provides redirection for a subtree of the domain
 * name tree in the DNS.  That is, all names that end with a particular
 * suffix are redirected to another part of the DNS.
 * Based on RFC6672
 *
 * @link http://tools.ietf.org/html/rfc6672
 */
class DnameRdata extends CnameRdata
{
    const TYPE = 'DNAME';
}