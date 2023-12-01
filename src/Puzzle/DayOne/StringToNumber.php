<?php

namespace App\Puzzle\DayOne;

final class StringToNumber
{
    private const NUMBERS_MAPPING = [
      // Edge cases
      'oneight' => 18,
      'twone' => 21,
      'threeeight' => 38,
      'fiveight' => 58,
      'sevenine' => 79,
      'eightwo' => 82,
      'eighthree' => 83,
      'nineight' => 98,
      // Numbers
      'one' => 1,
      'two' => 2,
      'three' => 3,
      'four' => 4,
      'five' => 5,
      'six' => 6,
      'seven' => 7,
      'eight' => 8,
      'nine' => 9,
    ];

    public function convert(string $input): string
    {
        return strtr($input, array_combine(array_keys(self::NUMBERS_MAPPING), array_values(self::NUMBERS_MAPPING)));
    }
}
