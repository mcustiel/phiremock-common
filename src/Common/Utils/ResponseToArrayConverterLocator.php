<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Response;
use Mcustiel\Phiremock\Factory;

class ResponseToArrayConverterLocator
{
    /** @var Factory */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return \Mcustiel\Phiremock\Common\Utils\ResponseToArrayConverter
     */
    public function locate(Response $response)
    {
        if ($response->isHttpResponse()) {
            return $this->factory->createHttpResponseToArrayConverter();
        }

        return $this->factory->createProxyResponseToArrayConverter();
    }
}
