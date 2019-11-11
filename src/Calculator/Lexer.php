<?php


namespace App\Calculator;


class Lexer
{
    private $tokens = [];

    public function tokenize(string $data) : array
    {
        $this->tokens = [];
        $position = 0;

        while (isset($data[$position])) {
            $currentChar = $data[$position];
            $tokenType = null;
            $value = null;

            switch ($currentChar) {
                case ' ':
                    break;
                case '+':
                case '-':
                case '*':
                case '/':
                case '&':
                case '|':
                case '^':
                    $tokenType = TokenType::OPERATOR_TYPE();
                    $value = $currentChar;
                break;
                case '0':
                case '1':
                case '2':
                case '3':
                case '4':
                case '5':
                case '6':
                case '7':
                case '8':
                case '9':
                    $num = [$currentChar];
                    $eatLetter = ($currentChar == '0' && isset($data[$position+1]) && $data[$position+1] == 'b');

                    while (isset($data[++$position]) && ((\is_numeric($data[$position]) || $data[$position] == '.') || $eatLetter))  {
                        $eatLetter = false;
                        $num[] = $data[$position];
                    }

                    $tokenType = TokenType::NUMBER_TYPE();
                    $value = \implode('', $num);
                $position--;
                break;
                case '(':
                    $tokenType = TokenType::PARENTHESES_OPEN_TYPE();
                break;
                case ')':
                    $tokenType = TokenType::PARENTHESES_CLOSE_TYPE();
                break;
                default:
                    throw new \Exception('Unknown character');
            }

            if ($tokenType) {
                $this->tokens[] = new Token($tokenType, $value);
            }

            $position++;
        }

        return $this->tokens;
    }

    public function getTokens() : array
    {
        return $this->tokens;
    }
}
