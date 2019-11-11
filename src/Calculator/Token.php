<?php


namespace App\Calculator;


class Token
{
    /**
     * @var TokenType
     */
    private $tokenType;

    /**
     * @var string
     */
    private $value;

    public function __construct(TokenType $tokenType, ?string $value = null)
    {
        $this->tokenType = $tokenType;
        $this->value = $value;
    }

    public function getTokenType(): int
    {
        return $this->tokenType->getTokenType();
    }

    public function getValue(): string
    {
        return $this->value;
    }

}
