<?php

declare(strict_types=1);

namespace App\Utils;

final class FileToArray
{
    /**
     * @return array<int, string>
     */
    public function convert(string $input): array
    {
        $file = file($input);
        $array = [];

        if ($file) {
            foreach ($file as $line) {
                $array[] = trim($line);
            }
        }

        return $array;
    }
}
