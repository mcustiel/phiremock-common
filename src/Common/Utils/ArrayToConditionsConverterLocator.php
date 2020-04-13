<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Version;
use Mcustiel\Phiremock\Factory;

class ArrayToConditionsConverterLocator
{
    /** @var Factory */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function locate(Version $version): ArrayToRequestConditionConverter
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
