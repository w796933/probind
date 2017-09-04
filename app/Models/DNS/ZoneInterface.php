<?php

namespace App\Models\DNS;

interface ZoneInterface
{
    /**
     * @param ResourceRecordInterface[] $resourceRecord
     */
    public function setResourceRecords(array $resourceRecord);

    /**
     * @param ResourceRecordInterface $resourceRecord
     */
    public function addResourceRecord(ResourceRecordInterface $resourceRecord);

    /**
     * @return ResourceRecordInterface[]
     */
    public function getResourceRecords();

    /**
     * @param int $defaultTtl
     */
    public function setDefaultTtl(int $defaultTtl);

    /**
     * @return int
     */
    public function getDefaultTtl(): int;

    /**
     * @param string $zone A fully qualified zone name
     */
    public function setName(string $zone);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @param string $value
     */
    public function addControlEntry(string $name, string $value);

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getControlEntry(string $name);

    /**
     * @return array
     */
    public function getControlEntries(): array;
}
