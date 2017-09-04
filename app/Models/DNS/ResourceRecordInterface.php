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

use App\Models\DNS\RData\RDataInterface;

interface ResourceRecordInterface
{
    /**
     * Set the name for the resource record.
     * Eg. "subdomain.example.com.".
     *
     * @param $name
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param RDataInterface $rData
     */
    public function setRData(RDataInterface $rData);

    /**
     * @return RDataInterface
     */
    public function getRData(): RDataInterface;

    /**
     * Set the time to live.
     *
     * @param int $ttl
     */
    public function setTtl(int $ttl);

    /**
     * @return int
     */
    public function getTtl(): int;

    /**
     * Set a comment for the record.
     *
     * @param $comment
     */
    public function setComment(string $comment);

    /**
     * Get the record's comment.
     *
     * @return string
     */
    public function getComment(): string;
}