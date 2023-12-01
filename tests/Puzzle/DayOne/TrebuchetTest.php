<?php

namespace App\Tests\Puzzle\DayOne;

use App\Puzzle\DayOne\Trebuchet;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TrebuchetTest extends KernelTestCase
{
    public function testPartOne(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $trebuchet = $container->get(Trebuchet::class);

        $this->assertEquals('55029', $trebuchet->partOne());
    }

    public function testPartTwo(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $trebuchet = $container->get(Trebuchet::class);

        $this->assertEquals('55686', $trebuchet->partTwo());
    }
}
