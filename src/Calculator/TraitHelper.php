<?php


namespace App\Calculator;


trait TraitHelper
{
    private function getFurthestLeftNodeParent(Node $node) : Node
    {
        $nodeLeft = $node->nodeLeft;

        while ($nodeLeft->nodeLeft) {
            $nodeLeft = $nodeLeft->nodeLeft;
        }

        return $nodeLeft->parent;
    }
}
