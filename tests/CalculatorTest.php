<?php

namespace App\Tests;

use App\Calculator\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{

    private $calculations = [
        "5+5" => "10",
        "2*5" => "10",
        "2*5 +2" => "12",
        "2-2" => "0",
        "0b0001 & 0b0001" => "1",
        "0b0010 | 0b0001" => "3",
        "5+2*2" => "9",
        "5+2*2^2" => "13",
    ];

    public function testCalculate()
    {
        $calculator = new Calculator();

        foreach ($this->calculations as $formula => $expected_result) {
            $result = $calculator->calculate($formula);
            $this->assertEquals($expected_result, $result);
        }
    }
}
