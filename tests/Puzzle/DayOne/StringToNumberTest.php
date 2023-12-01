<?php

namespace App\Tests\Puzzle\DayOne;

use App\Puzzle\DayOne\StringToNumber;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StringToNumberTest extends KernelTestCase
{
    public function testBasicNumber(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $stringToNumber = $container->get(StringToNumber::class);

        $this->assertEquals('219', $stringToNumber->convert('two1nine'));
        $this->assertEquals('abc123xyz', $stringToNumber->convert('abcone2threexyz'));
        $this->assertEquals('49872', $stringToNumber->convert('4nineeightseven2'));
        $this->assertEquals('7pqrst6teen', $stringToNumber->convert('7pqrstsixteen'));
    }

    public function testEdgeCases(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $stringToNumber = $container->get(StringToNumber::class);

        $this->assertEquals('823', $stringToNumber->convert('eightwothree'));
        $this->assertEquals('x2134', $stringToNumber->convert('xtwone3four'));
        $this->assertEquals('z18234', $stringToNumber->convert('zoneight234'));
    }
}
