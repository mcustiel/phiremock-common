<?php
namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Factory;

class ArrayToResponseConverterLocator
{
    /** @var Factory */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /** @return ArrayToResponseConverter */
    public function locate(array $responseArray)
    {
        if (isset($responseArray['proxyTo'])) {
            return $this->factory->createArrayToProxyResponseConverter();
        }
        return $this->factory->createArrayToHttpResponseConverter();
    }
}
