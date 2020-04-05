<?php

namespace Mcustiel\Phiremock\Domain\Http;

use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class Method extends StringValue
{
    /** @var string * */
    private $method;

    public function __construct(string $method)
    {
        var_export('method constructor');
        $this->ensureIsValidHttpMethod($method);
        $this->method = strtolower($method);
    }

    public static function get(): self
    {
        return new self(MethodsEnum::GET);
    }

    public static function post(): self
    {
        return new self(MethodsEnum::POST);
    }

    public static function put(): self
    {
        return new self(MethodsEnum::PUT);
    }

    public static function delete(): self
    {
        return new self(MethodsEnum::DELETE);
    }

    public static function fetch(): self
    {
        return new self(MethodsEnum::FETCH);
    }

    public static function options(): self
    {
        return new self(MethodsEnum::OPTIONS);
    }

    public static function patch(): self
    {
        return new self(MethodsEnum::PATCH);
    }

    public static function head(): self
    {
        return new self(MethodsEnum::HEAD);
    }

    public function asString(): string
    {
        return $this->method;
    }

    public function equals(Method $other): bool
    {
        return $this->asString() === $other->asString();
    }

    private function ensureIsValidHttpMethod(string $method): void
    {
        var_export('ensurer');
        if (!MethodsEnum::isValid($method)) {
            throw new \InvalidArgumentException(sprintf('Invalid http method: %s', var_export($method, true)));
        }
    }
}
