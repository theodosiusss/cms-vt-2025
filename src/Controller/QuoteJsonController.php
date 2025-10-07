<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/movie')]
final class QuoteJsonController extends AbstractController
{
    #[Route('', name: 'app_movies_get_json', methods: ['GET'])]
    public function getAll(MovieRepository $repo, SerializerInterface $serializer): JsonResponse
    {
        $movies = $repo->findAll();

        try {
            $json = $serializer->serialize($movies, 'json', ['groups' => ['movie:read']]);
        } catch (ExceptionInterface $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return JsonResponse::fromJsonString($json);
    }
    #[Route('/{id}', name: 'app_movies_get_single_json', methods: ['GET'])]
    public function get(MovieRepository $repo, SerializerInterface $serializer, Movie $movie): JsonResponse
    {
        try {
            $json = $serializer->serialize($movie, 'json', ['groups' => ['movie:read']]);
        } catch (ExceptionInterface $e) {
            $this->redirectToRoute("app_movies_get_json");
        }
        return JsonResponse::fromJsonString($json);
    }
    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Movie $movie, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($movie);
        $em->flush();

        return $this->json(['message' => 'Movie deleted']);
    }
    #[Route('', methods: ['POST'])]
    public function post(Request $request, EntityManagerInterface $em,SerializerInterface $serializer): JsonResponse
    {
        $json = $request->getContent();
        try {
            $movie = $serializer->deserialize($json, Movie::class, 'json');
            $em->persist($movie);
            $em->flush();

            $responseJson = $serializer->serialize($movie, 'json', ['groups' => ['movie:read']]);

        } catch (ExceptionInterface $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }


        return JsonResponse::fromJsonString($responseJson);
    }
    #[Route('/{movie}', methods: ['PUT'])]
    public function put(Request $request,MovieRepository $movieRepository, EntityManagerInterface $em,SerializerInterface $serializer, Movie $movie): JsonResponse
    {
        $json = $request->getContent();

        try {
            $serializer->deserialize(
                $json,
                Movie::class,
                'json',
                ['object_to_populate' => $movie]
            );

            $em->flush();

            $responseJson = $serializer->serialize($movie, 'json', ['groups' => ['movie:read']]);
            return JsonResponse::fromJsonString($responseJson);


        } catch (ExceptionInterface $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


}
