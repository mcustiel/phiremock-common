<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\BinaryInfo;
use Mcustiel\Phiremock\Domain\Http\BinaryBody;
use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeadersCollection;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\Http\Uri;
use Mcustiel\Phiremock\Domain\ProxyResponse;

class ArrayToProxyResponseConverter extends ArrayToResponseConverter
{
    protected function convertResponse(
        array $responseArray,
        Delay $delay,
        ScenarioState $newScenarioState = null
    ) {
        if (empty($responseArray['proxyTo'])) {
            throw new \InvalidArgumentException('Trying to create a proxied response with an empty uri');
        }

        return new ProxyResponse(
            new Uri($responseArray['proxyTo']),
            $delay,
            $newScenarioState
        );
    }
}
