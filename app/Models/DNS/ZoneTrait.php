<?php


namespace App\Models\DNS;

trait ZoneTrait
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ResourceRecord[]
     */
    private $resourceRecords = [];

    /**
     * @var int
     */
    private $defaultTtl;

    /**
     * @var array
     */
    private $ctrlEntries = [];

    /**
     * @param ResourceRecordInterface[] $resourceRecord
     */
    public function setResourceRecords(array $resourceRecord)
    {
        foreach ($resourceRecord as $rr) {
            /* @var ResourceRecordInterface $rr */
            $this->addResourceRecord($rr);
        }
    }

    /**
     * @param ResourceRecordInterface $resourceRecord
     */
    public function addResourceRecord(ResourceRecordInterface $resourceRecord)
    {
        $this->resourceRecords[] = $resourceRecord;
    }

    /**
     * @return ResourceRecordInterface[]
     */
    public function getResourceRecords()
    {
        return $this->resourceRecords;
    }

    /**
     * @param int $defaultTtl
     */
    public function setDefaultTtl(int $defaultTtl)
    {
        $this->defaultTtl = (int)$defaultTtl;
    }

    /**
     * @return int
     */
    public function getDefaultTtl(): int
    {
        return $this->defaultTtl;
    }

    /**
     * @param string $name A fully qualified zone name
     *
     * @throws ZoneException
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
     * @param string $value
     */
    public function addControlEntry(string $name, string $value)
    {
        $this->ctrlEntries[] = ['name' => $name, 'value' => $value];
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function getControlEntry(string $name): array
    {
        $out = [];
        foreach ($this->ctrlEntries as $entry) {
            if ($name === $entry['name']) {
                $out[] = $entry['value'];
            }
        }

        return $out;
    }

    /**
     * @return array
     */
    public function getControlEntries()
    {
        return $this->ctrlEntries;
    }
}
