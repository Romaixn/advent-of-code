<?php

namespace App\Puzzle\DayOne;

use App\Puzzle\Day;

final class Trebuchet extends Day
{
    public function __construct(
        private readonly StringToNumber $stringToNumber,
    ) {
    }

    public function partOne(): string
    {
        $input = $this->inputFetcher->fetch(1);
        $result = 0;

        foreach (explode("\n", $input) as $line) {
            if (empty($line)) {
                continue;
            }

            $array = str_split($line);
            $array = array_filter($array, 'is_numeric');
            $firstNumber = reset($array);
            $lastNumber = end($array);

            $result += (int) ($firstNumber.$lastNumber);
        }

        return (string) $result;
    }

    public function partTwo(): string
    {
        $input = $this->inputFetcher->fetch(1);
        $result = 0;

        foreach (explode("\n", $input) as $line) {
            if (empty($line)) {
                continue;
            }

            $line = $this->stringToNumber->convert($line);
            $array = str_split($line);
            $array = array_filter($array, 'is_numeric');
            $firstNumber = reset($array);
            $lastNumber = end($array);

            $result += (int) ($firstNumber.$lastNumber);
        }

        return (string) $result;
    }
}
