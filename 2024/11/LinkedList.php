<?php

namespace Day11;

/**
 * @template T
 * @implements \IteratorAggregate<int, T>
 */
class LinkedList implements \IteratorAggregate
{
    /**
     * @var ?Node<T>
     */
    private ?Node $head = null;

    /**
     * @var ?Node<T>
     */
    private ?Node $tail = null;

    /**
     * @param T[] $array
     * @return self<T>
     */
    public static function fromArray(array $array): self
    {
        /**
         * @var LinkedList<T>
         */
        $list = new self();

        foreach ($array as $value) {
            $list->append($value);
        }

        return $list;
    }

    /**
     * @param T $value
     */
    public function append($value): void
    {
        $node = new Node($value);

        if ($this->head === null || $this->tail === null) {
            $this->head = $this->tail = $node;
        } else {
            $this->tail->next = $node;
            $this->tail = $this->tail->next;
        }
    }

    /**
     * @return \Generator<int, T>
     */
    public function getIterator(): \Generator
    {
        $curr = $this->head;

        while ($curr !== null) {
            yield $curr->value;
            $curr = $curr->next;
        }
    }

    /**
     * @return ?Node<T>
     */
    public function head(): ?Node
    {
        return $this->head;
    }
}

/**
 * @template T
 */
class Node
{
    /**
     * @var T
     */
    public $value;

    /**
     * @var ?Node<T>
     */
    public ?Node $next;

    /**
     * @param T $value
     * @param ?Node<T> $next
     */
    public function __construct($value, ?Node $next = null)
    {
        $this->value = $value;
        $this->next = $next;
    }
}
