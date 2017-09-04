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

use App\Models\DNS\ResourceRecord;

trait FormatTableTrait
{
    /**
     * The amount of left padding before an Rdata component.
     *
     * @var int
     */
    private $padding;

    /**
     * @param int $padding
     */
    public function setPadding(int $padding)
    {
        $this->padding = (int)$padding;
    }

    /**
     * Get the length of the longest variable.
     *
     * @return mixed
     */
    abstract public function longestVarLength();

    /**
     * Returns a padded line with comment.
     *
     * @param string $text
     * @param string $comment
     *
     * @return string
     */
    private function makeLine(string $text, string $comment = null): string
    {
        $pad = $this->longestVarLength();
        $output = str_repeat(' ', $this->padding) .
            str_pad($text, $pad);
        if (null !== $comment) {
            $output .= ' ' . ResourceRecord::COMMENT_DELIMINATOR . $comment;
        }
        $output .= PHP_EOL;
        return $output;
    }
}