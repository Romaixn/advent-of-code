<?php

namespace App\Controller;

use App\Puzzle\DayTwo\Cube;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PuzzleController extends AbstractController
{
    #[Route('/day/{day}', name: 'puzzle')]
    public function puzzle(Cube $puzzle): Response
    {
        return $this->render('puzzle.html.twig', [
          'part_one' => $puzzle->partOne(),
          'part_two' => $puzzle->partTwo(),
        ]);
    }
}
