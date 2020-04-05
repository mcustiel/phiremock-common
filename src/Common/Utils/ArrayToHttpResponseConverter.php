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
use Mcustiel\Phiremock\Domain\Response;

class ArrayToHttpResponseConverter extends ArrayToResponseConverter
{
    const STRING_START = 0;

    protected function convertResponse(
        array $responseArray,
        ?Delay $delay,
        ?ScenarioState $newScenarioState
    ): Response {
        if (!isset($responseArray['response']['statusCode'])) {
            $responseArray['response']['statusCode'] = 200;
        }

        return new HttpResponse(
            new StatusCode((int) $responseArray['response']['statusCode']),
            $this->getBody($responseArray['response']),
            $this->getHeaders($responseArray['response']),
            $delay,
            $newScenarioState
        );
    }

    /** @return \Mcustiel\Phiremock\Domain\Http\HeadersCollection */
    private function getHeaders($responseArray)
    {
        if (!empty($responseArray['headers'])) {
            return $this->convertHeaders($responseArray['headers']);
        }

        return null;
    }

    /** @return \Mcustiel\Phiremock\Domain\Http\Body */
    private function getBody(array $responseArray)
    {
        if (isset($responseArray['body'])) {
            if ($this->isBinaryBody($responseArray['body'])) {
                return new BinaryBody($responseArray['body']);
            }

            return new Body($responseArray['body']);
        }

        return null;
    }

    /**
     * @param string $body
     *
     * @return bool
     */
    private function isBinaryBody($body)
    {
        return BinaryInfo::BINARY_BODY_PREFIX === substr($body, self::STRING_START, BinaryInfo::BINARY_BODY_PREFIX_LENGTH);
    }

    /**
     * @param array $headers
     *
     * @throws \InvalidArgumentException
     *
     * @return \Mcustiel\Phiremock\Domain\Http\HeadersCollection
     */
    private function convertHeaders($headers)
    {
        if (!\is_array($headers)) {
            throw new \InvalidArgumentException('Response headers are invalid: ' . var_export($headers, true));
        }

        $headerCollection = new HeadersCollection();
        foreach ($headers as $headerName => $headerValue) {
            $headerCollection->setHeader(
                new Header(
                    new HeaderName($headerName),
                    new HeaderValue($headerValue)
                )
            );
        }

        return $headerCollection;
    }
}
