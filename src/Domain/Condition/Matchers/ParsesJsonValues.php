<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Domain\Condition\Matchers;

trait ParsesJsonValues
{
    private function parseJsonValue(string $value)
    {
        $decodedValue = json_decode($value, true);
        if (\JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException('JSON parsing error: '.json_last_error_msg());
        }

        return $decodedValue;
    }

    private function getParsedJsonValue(string $value)
    {
        try {
            return $this->parseJsonValue($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function isInvalidNonNullJson(string $value, $parsedValue): bool
    {
        return null === $parsedValue && 'null' !== trim($value);
    }
}
