<?php

namespace App\Puzzle;

use App\Utils\InputFetcher;
use Symfony\Contracts\Service\Attribute\Required;

abstract class Day implements DayInterface
{
    protected InputFetcher $inputFetcher;

    #[Required]
    public function setInputFetcher(InputFetcher $inputFetcher): void
    {
        $this->inputFetcher = $inputFetcher;
    }
}
