<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Response;

class ProxyResponseToArrayConverter extends ResponseToArrayConverter
{
    public function convert(Response $response)
    {
        /** @var \Mcustiel\Phiremock\Domain\ProxyResponse $response */
        $responseArray = [];
        $responseArray['url'] = $response->getUri()->asString();

        return array_merge($responseArray, parent::convert($response));
    }
}
