<?php

namespace Mcustiel\Phiremock\Domain;

class AbstractArrayIterator implements \Iterator, \Countable
{
    /**
     * @var array
     */
    protected $array;

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

    /** @return bool */
    public function isEmpty()
    {
        return empty($this->array);
    }
}
