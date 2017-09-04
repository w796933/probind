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

use App\Models\DNS\Rdata\RdataInterface;

class ResourceRecord implements ResourceRecordInterface
{
    const COMMENT_DELIMINATOR = '; ';
    const MULTILINE_BEGIN = '(';
    const MULTILINE_END = ')';
    /**
     * @var string
     */
    private $class;
    /**
     * @var RdataInterface
     */
    private $RData;
    /**
     * @var int
     */
    private $ttl;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $comment;

    /**
     * @param string         $name
     * @param RdataInterface $RData
     * @param int            $ttl
     * @param string         $class
     * @param string         $comment
     */
    public function __construct(
        string $name = null,
        RdataInterface $RData = null,
        int $ttl = null,
        string $class = null,
        string $comment = null
    ) {
        if (null !== $name) {
            $this->setName($name);
        }
        if (null !== $class) {
            $this->setClass($class);
        }
        if (null !== $ttl) {
            $this->setTtl($ttl);
        }
        $this->RData = $RData;
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @throws \UnexpectedValueException
     */
    public function setClass(string $class)
    {
        if (!Classes::isValid($class)) {
            throw new \UnexpectedValueException(sprintf('No such class as "%s"', $class));
        }
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        if (null === $this->RData) {
            return false;
        }
        return $this->RData->getType();
    }

    /**
     * Get the record's comment.
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Set a comment for the record.
     *
     * @param string $comment
     */
    public function setComment(string $comment)
    {
        $comment = preg_replace('/(?:\n|\r)/', '', $comment);
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = (string)$name;
    }

    /**
     * @return RdataInterface
     */
    public function getRData(): RdataInterface
    {
        return $this->RData;
    }

    /**
     * @param RdataInterface $RData
     */
    public function setRData(RdataInterface $RData)
    {
        $this->RData = $RData;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * @param int $ttl
     */
    public function setTtl(int $ttl)
    {
        $this->ttl = (int)$ttl;
    }
}