<?php

namespace App\Tests\Puzzle\DayOne;

use App\Puzzle\DayTwo\Cube;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CubeTest extends KernelTestCase
{
    public function testPartOne(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $cube = $container->get(Cube::class);

        $this->assertEquals('2716', $cube->partOne());
    }

    public function testPartTwo(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $cube = $container->get(Cube::class);

        $this->assertEquals('72227', $cube->partTwo());
    }
}
