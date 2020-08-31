<?php

namespace Mcustiel\Phiremock\Domain\Http;

class FormFieldName
{
    /** @var string * */
    private $fieldName;

    public function __construct(string $fieldName)
    {
        $this->ensureIsNotEmpty($fieldName);
        $this->fieldName = $fieldName;
    }

    public function asString(): string
    {
        return $this->fieldName;
    }

    public function equals(self $other): bool
    {
        return $other->asString() === $this->asString();
    }

    private function ensureIsNotEmpty(string $fieldName): void
    {
        if ($fieldName === '') {
            throw new \InvalidArgumentException('Field name can\t be empty');
        }
    }
}
