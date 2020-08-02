<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Factory;

class RequestConditionToArrayConverterLocator
{
    /** @var Factory */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function locate(Expectation $expectation): RequestConditionToArrayConverter
    {
        switch ($expectation->getVersion()->asString()) {
            case '1':
                return $this->factory->createRequestConditionToArrayConverter();
            case '2':
                return $this->factory->createRequestConditionToArrayV2Converter();
        }
        throw new \LogicException('Unimplemented config version');
    }
}
