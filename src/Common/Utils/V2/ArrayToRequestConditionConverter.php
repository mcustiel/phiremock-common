<?php

namespace Mcustiel\Phiremock\Common\Utils\V2;

use Mcustiel\Phiremock\Domain\Conditions\Method\MethodCondition;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodMatcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter as ArrayToRequestConditionConverterV1;

class ArrayToRequestConditionConverter extends ArrayToRequestConditionConverterV1
{
    protected function convertMethodCondition(array $requestArray): ?MethodCondition
    {
        if (!empty($requestArray['method'])) {
            $method = $requestArray['method'];
            if (!\is_array($method)) {
                throw new \InvalidArgumentException('Method condition is invalid: ' . var_export($method, true));
            }

            return new MethodCondition(
                new MethodMatcher(key($method)),
                new StringValue(current($method))
            );
        } return null;
    }
}
