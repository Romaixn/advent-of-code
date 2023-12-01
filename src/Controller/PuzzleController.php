<?php

namespace App\Controller;

use App\Puzzle\DayOne\Trebuchet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PuzzleController extends AbstractController
{
    #[Route('/day/{day}', name: 'puzzle')]
    public function puzzle(Trebuchet $dayOne): Response
    {
        return $this->render('puzzle.html.twig', [
          'part_one' => $dayOne->partOne(),
          'part_two' => $dayOne->partTwo(),
        ]);
    }
}
