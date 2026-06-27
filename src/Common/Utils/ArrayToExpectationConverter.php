<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Expectation;

interface ArrayToExpectationConverter
{
    public function convert(array $expectationArray): Expectation;
}
