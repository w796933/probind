<?php

namespace DNS;

use App\Models\DNS\ZoneBuilder;

class ZoneBuilderTest extends DNSTestCase
{
    public function testBuild()
    {
        $zone = $this->buildTestZone();
        $zoneBuilder = new ZoneBuilder();
        $this->assertEquals($this->expected, $output = $zoneBuilder->build($zone));

        if (true == $this->getEnvVariable(self::PHP_ENV_PRINT_TEST_ZONE)) {
            $this->printBlock($output, 'TEST ZONE FILE');
        }
    }
}
