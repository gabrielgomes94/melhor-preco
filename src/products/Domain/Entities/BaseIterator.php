<?php

namespace Src\Products\Domain\Entities;

use Countable;
use Iterator;

abstract class BaseIterator implements Iterator, Countable
{
    /**
     * @var array
     */
    protected $objects = [];

    /**
     * @var int
     */
    private $position = 0;

    abstract protected function build(array $data): array;

    public function __construct(array $data = [])
    {
        $this->objects = $this->build($data);
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->objects[$this->position] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     * {@inheritDoc}
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return isset($this->objects[$this->position]);
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->objects);
    }
}
