<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeadersCollection;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\StatusCode;

trait HttpResponseArrayParsing
{
    private function getHeaders(array $responseArray): ?HeadersCollection
    {
        if (!isset($responseArray['headers'])) {
            return null;
        }

        $headers = $responseArray['headers'];
        if (empty($headers)) {
            return null;
        }

        if (!\is_array($headers)) {
            throw new \InvalidArgumentException('Response headers are invalid: '.var_export($headers, true));
        }

        return $this->convertHeaders($headers);
    }

    private function getBody(array $responseArray): ?Body
    {
        if (!isset($responseArray['body'])) {
            return null;
        }

        $body = $responseArray['body'];
        if (\is_array($body)) {
            $encodedBody = json_encode($body);
            $body = false === $encodedBody ? '' : $encodedBody;
        } elseif (!\is_string($body)) {
            if (!\is_scalar($body) && !$body instanceof \Stringable) {
                throw new \InvalidArgumentException('Response body is invalid: '.var_export($body, true));
            }

            $body = (string) $body;
        }

        return BodyHelper::getBodyObject($body);
    }

    private function getStatusCode(array $responseArray): StatusCode
    {
        $statusCode = $responseArray['statusCode'] ?? 200;
        if (!\is_int($statusCode)) {
            throw new \InvalidArgumentException(sprintf('Status code must be an integer. Got: %s', \gettype($statusCode)));
        }

        return new StatusCode($statusCode);
    }

    private function convertHeaders(array $headers): HeadersCollection
    {
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
