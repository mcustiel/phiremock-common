<?php

namespace Mcustiel\Phiremock\Domain;

class AbstractArrayCollection implements \Iterator, \Countable, \JsonSerializable
{
    /**
     * @var array
     */
    private $array;

    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Iterator::next()
     */
    public function next()
    {
        next($this->array);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Iterator::valid()
     */
    public function valid()
    {
        $key = key($this->array);

        return false !== $key && null !== $key;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Iterator::current()
     */
    public function current()
    {
        return current($this->array);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Iterator::rewind()
     */
    public function rewind()
    {
        reset($this->array);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Iterator::key()
     */
    public function key()
    {
        return key($this->array);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Countable::count()
     */
    public function count()
    {
        return \count($this->array);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->array);
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return $this->array;
    }

    /**
     * @param int|string $key
     * @param mixed      $value
     *
     * @throws \InvalidArgumentException
     */
    protected function set($key, $value)
    {
        if (!\is_string($key) && !\is_int($key)) {
            throw new \InvalidArgumentException(
                sprintf('Key must be integer or string. Got: %s', \gettype($key))
            );
        }
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
}
