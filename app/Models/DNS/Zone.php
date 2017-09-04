<?php

namespace App\Models\DNS;

class Zone implements ZoneInterface
{
    use ZoneTrait;

    /**
     * @param string                    $name
     * @param string                    $defaultTtl
     * @param ResourceRecordInterface[] $resourceRecords
     */
    public function __construct($name = null, $defaultTtl = null, array $resourceRecords = [])
    {
        if (null !== $name) {
            $this->setName($name);
        }

        $this->setDefaultTtl($defaultTtl);
        $this->setResourceRecords($resourceRecords);
    }

    /**
     * @param string $name A fully qualified zone name
     *
     * @throws ZoneException
     */
    public function setName(string $name)
    {
        if (!Validator::rrName($name, true)) {
            throw new ZoneException(sprintf('Zone "%s" is not a fully qualified domain name.', $name));
        }

        $this->name = $name;
    }
}
