<?php

namespace App\Controller;

use App\Services\Games;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Animal;
use Symfony\Component\Routing\Attribute\Route;

final class PaperPlaneTournamentController extends AbstractController
{
    #[Route('/results/{count}', name: 'app_paper_plane_tournament', requirements: ['id' => '\d+'], defaults: ['count' => 0])]
    public function getGame(int $count, Games $games): Response
    {

        if($count <= 0) {
            return $this->render("paperplane/main.html.twig", ["games" => $games->getGames()]);
        }
        else {
            return $this->render("paperplane/detail.html.twig", ["game" => $games->getGames()[$count-1]]);
        }
    }
    #[Route('/animal', name: 'app_zoo')]
    public function getAnimal(Animal $animal): Response
    {

      return new Response($animal->getNoise());

    }
}
