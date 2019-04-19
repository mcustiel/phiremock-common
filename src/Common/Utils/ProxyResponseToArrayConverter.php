<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Response;

class ProxyResponseToArrayConverter extends ResponseToArrayConverter
{
    /** @param \Mcustiel\Phiremock\Domain\ProxyResponse $response */
    public function convert(Response $response)
    {
        $responseArray = [];
        $responseArray['url'] = $response->getUrl()->asString();

        return array_merge($responseArray, parent::convert($response));
    }
}
