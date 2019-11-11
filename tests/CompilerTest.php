<?php

namespace App\Tests;

use App\Calculator\Compiler;
use App\Calculator\Node;
use PHPUnit\Framework\TestCase;

class CompilerTest extends TestCase
{

    public function testCompileNode1()
    {
        $this->givenNodeTest($this->node1());
    }
    public function testCompileNode2()
    {
        $this->givenNodeTest($this->node2());
    }

    private function givenNodeTest(array $nodeResult)
    {
        $compiler = new Compiler();
        list($node, $expected_result) = $nodeResult;
        $result = $compiler->compile($node);

        $this->assertEquals($expected_result, $result);
    }

    private function node1() : array
    {
        $root = new Node(null, "+");
        $root->nodeLeft = new Node($root, "5");
        $root->nodeRight = new Node($root, "5");

        return [$root, "10"];
    }

    private function node2() : array
    {
        $root = new Node(null, "+");
        $root->nodeLeft = new Node($root, "*");
        $root->nodeRight = new Node($root, "5");

        $root->nodeLeft->nodeLeft = new Node($root->nodeLeft, "2");
        $root->nodeLeft->nodeRight = new Node($root->nodeLeft, "10");

        return [$root, "25"];
    }

    private function node3() : array
    {
        $root = new Node(null, "|");
        $root->nodeLeft = new Node($root, "0001");
        $root->nodeRight = new Node($root, "0010");

        return [$root, "9"];
    }

}
