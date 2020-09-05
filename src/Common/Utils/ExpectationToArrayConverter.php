<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Expectation;

interface ExpectationToArrayConverter
{
    public function convert(Expectation $expectation): array;
}
