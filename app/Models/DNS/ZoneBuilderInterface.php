<?php

namespace App\Models\DNS;

interface ZoneBuilderInterface
{
    /**
     * Renders a zone.
     *
     * @param ZoneInterface $zone
     *
     * @return string
     */
    public function build(ZoneInterface $zone): string;
}
