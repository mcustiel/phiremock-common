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
    const LINK = 'LINK';

    private const VALID_METHODS = [
        self::GET,
        self::POST,
        self::PUT,
        self::DELETE,
        self::PATCH,
        self::FETCH,
        self::OPTIONS,
        self::HEAD,
        self::LINK,
    ];

    public static function isValid(string $method): bool
    {
        var_export('method validator');

        return \in_array(strtoupper($method), self::VALID_METHODS, true);
    }
}
