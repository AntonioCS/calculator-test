<?php


namespace App\Calculator;


class Compiler
{
    use TraitHelper;

    public function compile(Node $node) : string
    {
        $startNode = $this->getFurthestLeftNodeParent($node);
        $convertToProperType = function(string $str) {
            $base = (\strpos($str, '0b') === 0) ? 2 : 10;
            return \strpos($str, '.') !== false ? \floatval($str) : \intval($str, $base);
        };

        while ($startNode) {
            $result = null;
            $operation = $startNode->value;
            $leftValue = $convertToProperType($startNode->nodeLeft->value);
            $rightValue = $convertToProperType($startNode->nodeRight->value);

            switch ($operation) {
                case '+':
                    $result = $leftValue + $rightValue;
                break;
                case '-':
                    $result = $leftValue - $rightValue;
                break;
                case '*':
                    $result = $leftValue * $rightValue;
                break;
                case '/':
                    if ($rightValue == 0) {
                        throw new \Exception('Division by ZERO');
                    }
                    $result = $leftValue / $rightValue;
                break;
                case '^':
                    $result = \pow($leftValue, $rightValue);
                break;
                case '&':
                    $result = $leftValue & $rightValue;
                break;
                case '|':
                    $result = $leftValue | $rightValue;
                break;
            }

            $startNode->value = (string)$result;
            $startNode = $startNode->parent;
        }

        return $node->value;
    }
}
