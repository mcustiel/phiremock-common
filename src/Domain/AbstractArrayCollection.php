<?php

namespace Mcustiel\Phiremock\Domain;

class AbstractArrayCollection extends AbstractArrayIterator
{
    /**
     * @param int|string $key
     * @param mixed      $value
     *
     * @throws \InvalidArgumentException
     */
    protected function set($key, $value)
    {
        $this->ensureIsValidKey($key);
        $this->array[$key] = $value;
    }

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    protected function add($value)
    {
        $this->array[] = $value;
    }

    private function ensureIsValidKey($key)
    {
        if (!\is_string($key) && !\is_int($key)) {
            throw new \InvalidArgumentException(sprintf('Key must be integer or string. Got: %s', \gettype($key)));
        }
    }
}
