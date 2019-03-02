<?php

namespace Mcustiel\Phiremock\Domain\Http;

class Method
{
    /** @var string * */
    private $method;

    /**
     * @param string $method
     */
    public function __construct($method)
    {
        $this->ensureIsValidHttpMethod($method);
        $this->method = strtoupper($method);
    }

    public static function get()
    {
        return new self(MethodsEnum::GET);
    }

    public static function post()
    {
        return new self(MethodsEnum::POST);
    }

    public static function put()
    {
        return new self(MethodsEnum::PUT);
    }

    public static function delete()
    {
        return new self(MethodsEnum::DELETE);
    }

    public static function fetch()
    {
        return new self(MethodsEnum::FETCH);
    }

    public static function options()
    {
        return new self(MethodsEnum::OPTIONS);
    }

    public static function patch()
    {
        return new self(MethodsEnum::PATCH);
    }

    public static function head()
    {
        return new self(MethodsEnum::HEAD);
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->method;
    }

    private function ensureIsValidHttpMethod($method)
    {
        if (!\is_string($method)) {
            throw new \InvalidArgumentException(
                sprintf('Http method must be a string. Got: %s', \gettype($method))
            );
        }

        if (!MethodsEnum::isValid($method)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid http method: %s', var_export($method, true))
            );
        }
    }
}
