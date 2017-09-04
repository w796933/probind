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

namespace DNS\Rdata;

use App\Models\DNS\Rdata\TxtRdata;

class TxtRdataTest extends \TestCase
{
    public function testSetText()
    {
        $text = 'This is some text. It\'s a nice piece of text.';
        $txt = new TxtRdata();
        $txt->setText($text);
        $this->assertEquals($text, $txt->getText());
    }

    public function testOutput()
    {
        $text = 'This is some text. It\'s a nice piece of text.';
        $expected = '"This is some text. It\\\'s a nice piece of text."';
        $txt = new TxtRdata();
        $txt->setText($text);
        $this->assertEquals($expected, $txt->output());
    }
}