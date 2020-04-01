<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Factory;
use Mcustiel\Phiremock\Domain\Version;

class ArrayToConditionsConverterLocator
{
    /** @var Factory */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /** @return ArrayToResponseConverter */
    public function locate(Version $version)
    {
        switch ($version->asInt()) {
            case 1:
                return  $this->factory->createArrayToRequestConditionConverter();
            case 2:
                return $this->factory->createArrayToRequestConditionV2Converter();
        }
        throw new \LogicException('Unimplemented config version');

    }
}
