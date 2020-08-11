<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\V1\Factory as FactoryV1;
use Mcustiel\Phiremock\Common\Utils\V2\Factory as FactoryV2;
use Mcustiel\Phiremock\Domain\Expectation;

class ExpectationToArrayConverterLocator
{
    /** @var FactoryV1 */
    private $factoryV1;

    /** @var FactoryV2 */
    private $factoryV2;

    public function __construct(FactoryV1 $factoryV1, FactoryV2 $factoryV2)
    {
        $this->factoryV1 = $factoryV1;
        $this->factoryV2 = $factoryV2;
    }

    public function locate(Expectation $expectation): ExpectationToArrayConverter
    {
        switch ($expectation->getVersion()->asString()) {
            case '1':
                return $this->factoryV1->createArrayToExpectationConverter();
            case '2':
                return $this->factoryV2->createArrayToExpectationConverter();
        }
        throw new \Exception(
            sprintf('Unimplemented configuration version: %s', $expectation->getVersion()->asString())
        );
    }
}
