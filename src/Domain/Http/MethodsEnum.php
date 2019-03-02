<?php

namespace Mcustiel\Phiremock\Domain\Http;

class MethodsEnum
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const FETCH = 'FETCH';
    const HEAD = 'HEAD';
    const OPTIONS = 'OPTIONS';
    const PATCH = 'PATCH';

    const VALID_METHODS = [
        self::GET,
        self::POST,
        self::PUT,
        self::DELETE,
        self::FETCH,
        self::HEAD,
        self::OPTIONS,
        self::PATCH,
    ];

    /**
     * @param string $method
     *
     * @return bool
     */
    public static function isValid($method)
    {
        return \in_array(strtoupper($method), self::VALID_METHODS, true);
    }
}
