<?php

namespace Mcustiel\Phiremock\Domain\Condition;

class Json extends ConditionValue
{
    public function __construct(string $string)
    {
        parent::__construct($this->getDecodedJson($string));
    }

    public function asString(): string
    {
        return json_encode($this->get());
    }

    private function getDecodedJson(string $string): array
    {
        $decodedJson = json_decode($string, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException(sprintf('Invalid json: %s. Parsing error: %s', $string, json_last_error_msg()));
        }

        return $decodedJson;
    }
}
