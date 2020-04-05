<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Http\Uri;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\ProxyResponse;
use Mcustiel\Phiremock\Domain\Response;

class ArrayToProxyResponseConverter extends ArrayToResponseConverter
{
    protected function convertResponse(
        array $responseArray,
        ?Delay $delay,
        ?ScenarioState $newScenarioState
    ): Response {
        var_export('proxy converter');
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
