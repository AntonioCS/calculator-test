<?php


namespace App\Calculator;


class TokenType
{
    public const OPERATOR = 0;
    public const NUMBER = 1;
    public const PARENTHESES_OPEN = 2;
    public const PARENTHESES_CLOSE = 3;

    private $tokenType;

    public static function OPERATOR_TYPE() : TokenType
    {
        return new TokenType(self::OPERATOR);
    }

    public static function NUMBER_TYPE() : TokenType
    {
        return new TokenType(self::NUMBER);
    }

    public static function PARENTHESES_OPEN_TYPE() : TokenType
    {
        return new TokenType(self::PARENTHESES_OPEN);
    }

    public static function PARENTHESES_CLOSE_TYPE() :TokenType
    {
        return new TokenType(self::PARENTHESES_CLOSE);
    }

    public function getTokenType() : int
    {
        return $this->tokenType;
    }

    private function __construct(int $tokenType)
    {
        $this->tokenType = $tokenType;
    }
}


