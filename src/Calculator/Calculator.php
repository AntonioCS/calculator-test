<?php


namespace App\Calculator;

class Calculator
{
    public function calculate(string $calculation) : string
    {
        $lexer = new Lexer();
        $parser = new Parser();
        $compiler = new Compiler();

        return $compiler->compile(
            $parser->parse(
                $lexer->tokenize($calculation)
            )
        );
    }
}
