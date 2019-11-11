<?php


namespace App\Calculator;


class Node {
    /**
     * @var Node|null
     */
    public $parent;

    /**
     * @var string|null
     */
    public $value;

    /**
     * @var Node|null
     */
    public $nodeLeft;

    /**
     * @var Node|null
     */
    public $nodeRight;

    /**
     * @var int
     */
    public $weight = 0;

    public function __construct(?Node $parent, ?string $value, int $weight = 0)
    {
        $this->parent = $parent;
        $this->value = $value;
        $this->nodeLeft = null;
        $this->nodeRight = null;
        $this->weight = $weight;
    }
}
