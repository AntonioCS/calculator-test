<?php

namespace App\Tests;

use App\Calculator\Lexer;
use PHPUnit\Framework\TestCase;

class LexerTest extends TestCase
{
    public function testTokenize()
    {
        $lex = new Lexer();
        $test_data = "4 + 4";
        $lex->tokenize($test_data);

        $this->assertEquals(\count($lex->getTokens()), 3);
    }

    public function testTokenizeMoreData()
    {
        $lex = new Lexer();
        $test_data = "4 + 4 - (4 + 9)";
        $lex->tokenize($test_data);

        $this->assertEquals(\count($lex->getTokens()), 9);
    }
}
