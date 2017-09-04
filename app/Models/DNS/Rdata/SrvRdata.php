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
 * Class SrvRdata
 *
 * SRV is defined in RFC 2782
 * @link   https://www.ietf.org/rfc/rfc2782.txt
 *
 * @author Samuel Williams <sam@badcow.co>
 */
class SrvRdata extends CnameRdata
{
    const TYPE = 'SRV';
    const HIGHEST_PORT = 65535;
    const MAX_PRIORITY = 65535;
    const MAX_WEIGHT = 65535;
    /**
     * The priority of this target host. A client MUST attempt to
     * contact the target host with the lowest-numbered priority it can
     * reach; target hosts with the same priority SHOULD be tried in an
     * order defined by the weight field. The range is 0-65535. This
     * is a 16 bit unsigned integer.
     *
     * @var int
     */
    private $priority;
    /**
     * A server selection mechanism.  The weight field specifies a
     * relative weight for entries with the same priority. The range
     * is 0-65535. This is a 16 bit unsigned integer.
     *
     * @var int
     */
    private $weight;
    /**
     * The port on this target host of this service. The range is
     * 0-65535. This is a 16 bit unsigned integer
     *
     * @var int
     */
    private $port;

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     *
     * @throws \InvalidArgumentException
     */
    public function setPriority(int $priority)
    {
        if ($priority < 0 || $priority > static::MAX_PRIORITY) {
            throw new \InvalidArgumentException('Priority must be an unsigned integer on the range [0-65535]');
        }
        $this->priority = (int)$priority;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     *
     * @throws \InvalidArgumentException
     */
    public function setWeight(int $weight)
    {
        if ($weight < 0 || $weight > static::MAX_WEIGHT) {
            throw new \InvalidArgumentException('Weight must be an unsigned integer on the range [0-65535]');
        }
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     *
     * @throws \InvalidArgumentException
     */
    public function setPort(int $port)
    {
        if ($port < 0 || $port > static::HIGHEST_PORT) {
            throw new \InvalidArgumentException('Port must be an unsigned integer on the range [0-65535]');
        }
        $this->port = $port;
    }

    /**
     * {@inheritdoc}
     */
    public function output(): string
    {
        return sprintf('%s %s %s %s',
            $this->priority,
            $this->weight,
            $this->port,
            $this->target
        );
    }
}