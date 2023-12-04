<?php

namespace App\Puzzle\DayTwo;

use App\Puzzle\Day;

final class Cube extends Day
{
    public const RULES = [
      'red' => 12,
      'green' => 13,
      'blue' => 14,
    ];

    public function partOne(): string
    {
        $input = $this->inputFetcher->fetch(2);

        $games = $this->processInput($input);
        $onlyPossibleGames = $this->removeImpossibleGame($games);

        return (string) array_sum(array_keys($onlyPossibleGames));
    }

    public function partTwo(): string
    {
        $input = $this->inputFetcher->fetch(2);
        $games = $this->processInput($input);
        $res = 0;

        foreach ($games as $game) {
            $maxValues = [
              'red' => 0,
              'green' => 0,
              'blue' => 0,
            ];

            foreach ($game as $round) {
                foreach ($round as $color => $count) {
                    if ($count > $maxValues[$color]) {
                        $maxValues[$color] = $count;
                    }
                }
            }
            $res += $maxValues['red'] * $maxValues['green'] * $maxValues['blue'];
        }

        return (string) $res;
    }

    /**
     * @return array<int, array<int<0, max>, array<string, int>>>
     **/
    private function processInput(string $input): array
    {
        $games = [];
        foreach (explode("\n", $input) as $line) {
            if (empty($line)) {
                continue;
            }

            preg_match('/Game (\d+):/', $line, $match);
            $gameNumber = $match[1];

            preg_match_all('/(\d+) (\w+)/', $line, $matches, PREG_SET_ORDER);

            $gameData = [];
            foreach ($matches as $match) {
                $color = (string) $match[2];
                $quantity = (int) $match[1];
                $gameData[] = [$color => $quantity];
            }

            $games[(int) $gameNumber] = $gameData;
        }

        return $games;
    }

    /**
     * @param array<int, array<int<0, max>, array<string, int>>> $games
     *
     * @return array<int, array<int<0, max>, array<string, int>>>
     **/
    private function removeImpossibleGame(array $games): array
    {
        return array_filter($games, function ($games) {
            foreach ($games as $game) {
                foreach ($game as $color => $count) {
                    if ($count > self::RULES[$color]) {
                        return false;
                    }
                }
            }

            return true;
        });
    }
}
