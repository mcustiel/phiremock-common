<?php

namespace Mcustiel\Phiremock\Common\Utils\V2;

use Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverter as ConverterV1;
use Mcustiel\Phiremock\Domain\Conditions;

class ConditionsToArrayConverter extends ConverterV1
{
    private function convertMethod(Conditions $request, array &$requestArray)
    {
        $method = $request->getMethod();
        $requestArray['method'] = null === $method ? null : [
            $method->getMatcher()->asString() => $method->getValue()->asString(),
        ];
    }
}
