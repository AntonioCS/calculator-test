<?php

namespace App\Tests;

use App\Calculator\Node;
use App\Calculator\Parser;
use App\Calculator\Token;
use App\Calculator\TokenType;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    ///*
    public function testParseOneOperation()
    {
        $tokens = [ //5 + 4
            new Token(TokenType::NUMBER_TYPE(), '5'),
            new Token(TokenType::OPERATOR_TYPE(), '+'),
            new Token(TokenType::NUMBER_TYPE(), '4'),
        ];
        $parser = new Parser();
        $result = $parser->parse($tokens);
        $expectedResult = ['+', '5', '4'];
        $treeData = $this->getTreeData($result);

        $this->assertEquals($expectedResult, $treeData);
    }

    public function testParseTwoOperations()
    {
        $tokens = [ //5 + 4 + 3
            new Token(TokenType::NUMBER_TYPE(), '5'),
            new Token(TokenType::OPERATOR_TYPE(), '+'),
            new Token(TokenType::NUMBER_TYPE(), '4'),
            new Token(TokenType::OPERATOR_TYPE(), '+'),
            new Token(TokenType::NUMBER_TYPE(), '3'),
        ];
        $parser = new Parser();
        $result = $parser->parse($tokens);
        $expectedResult = ['+', '+', '5', '4', '3'];
        $treeData = $this->getTreeData($result);

        $this->assertEquals($expectedResult, $treeData);
    }

    public function testParseMultipleOperations()
    {
        $tokens = [ //3 + 4 * 5
            new Token(TokenType::NUMBER_TYPE(), '3'),
            new Token(TokenType::OPERATOR_TYPE(), '+'),
            new Token(TokenType::NUMBER_TYPE(), '4'),
            new Token(TokenType::OPERATOR_TYPE(), '*'),
            new Token(TokenType::NUMBER_TYPE(), '5'),
        ];
        $parser = new Parser();
        $result = $parser->parse($tokens);
        $expectedResult = ['+', '*', '4', '5', '3'];
        $treeData = $this->getTreeData($result);

        $this->assertEquals($expectedResult, $treeData);
    }

    public function testParseMultipleOperationsReverse()
    {
        $tokens = [ //3 * 4 + 5
            new Token(TokenType::NUMBER_TYPE(), '3'),
            new Token(TokenType::OPERATOR_TYPE(), '*'),
            new Token(TokenType::NUMBER_TYPE(), '4'),
            new Token(TokenType::OPERATOR_TYPE(), '+'),
            new Token(TokenType::NUMBER_TYPE(), '5'),
        ];
        $parser = new Parser();
        $result = $parser->parse($tokens);
        $expectedResult = ['+', '*', '3', '4', '5'];
        $treeData = $this->getTreeData($result);


        $this->assertEquals($expectedResult, $treeData);
    }

    public function testParseParens()
    {
        $tokens = [ //3 * (4 + 5)
            new Token(TokenType::NUMBER_TYPE(), '3'),
            new Token(TokenType::OPERATOR_TYPE(), '*'),
            new Token(TokenType::PARENTHESES_OPEN_TYPE()),
            new Token(TokenType::NUMBER_TYPE(), '4'),
            new Token(TokenType::OPERATOR_TYPE(), '+'),
            new Token(TokenType::NUMBER_TYPE(), '5'),
            new Token(TokenType::PARENTHESES_CLOSE_TYPE()),
        ];
        $parser = new Parser();
        $result = $parser->parse($tokens);
        $expectedResult = ['*', '+', '4', '5','3'];

        $treeData = $this->getTreeData($result);

        $this->assertEquals($expectedResult, $treeData);
    }

//*/
    public function testPower()
    {
        $tokens = [ // 5 + 2 * 2 ^ 2
            new Token(TokenType::NUMBER_TYPE(), '5'),
            new Token(TokenType::OPERATOR_TYPE(), '+'),
            new Token(TokenType::NUMBER_TYPE(), '2'),
            new Token(TokenType::OPERATOR_TYPE(), '*'),
            new Token(TokenType::NUMBER_TYPE(), '2'),
            new Token(TokenType::OPERATOR_TYPE(), '^'),
            new Token(TokenType::NUMBER_TYPE(), '2'),

        ];
        $parser = new Parser();
        $result = $parser->parse($tokens);
        $expectedResult = ['+','*', '^', '2', '2', '2', '5'];

        $treeData = $this->getTreeData($result);


        $this->assertEquals($expectedResult, $treeData);
    }

    private function getTreeData(Node $node) : array
    {
        $result = [$node->value];

        if ($node->nodeLeft) {
            $result = \array_merge($result, $this->getTreeData($node->nodeLeft));
        }

        if ($node->nodeRight) {
            $result = \array_merge($result, $this->getTreeData($node->nodeRight));
        }

        return $result;
    }
}
