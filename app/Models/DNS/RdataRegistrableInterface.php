<?php

namespace App\Models\DNS;

interface RdataRegistrableInterface
{
    /**
     * Indicates that an object can be injected with Rdata types. Useful when additional types beyond the scope
     * of the original library are required.
     *
     * @param string $type The type of rdata (should be uppercase eg: "DNAME", not "dname")
     * @param string $fqcn The fully qualified class name of the Rdata type
     *
     * @throws \InvalidArgumentException
     */
    public function registerRdataType(string $type, string $fqcn);

    /**
     * Returns true if the Rdata type has been registered.
     *
     * @param string $type
     *
     * @return bool
     */
    public function hasRdataType(string $type): bool;
}
