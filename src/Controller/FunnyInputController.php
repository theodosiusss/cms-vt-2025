<?php

namespace App\Controller;

use App\Entity\FunnyInput;
use App\Form\FunnyInputType;
use App\Repository\FunnyInputRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class FunnyInputController extends AbstractController
{
    #[Route('/funny/input', name: 'app_funny_input')]
    public function index(Request $request,EntityManagerInterface $em): Response
    {
        $funnyInput = new FunnyInput();

        $form = $this->createForm(FunnyInputType::class, $funnyInput);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($funnyInput);
            $em->flush();

            $this->addFlash('success', 'Daten erfolgreich gespeichert!');
            return $this->redirectToRoute('app_funny_input');
        }
        return $this->render('funny_input/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/funny/input/json', name: 'app_funny_input_json', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em, SerializerInterface $serializer,ValidatorInterface $validator
    ): JsonResponse
    {
        $json = $request->getContent();

        try {
            $input = $serializer->deserialize($json, FunnyInput::class, 'json');
            $errors = $validator->validate($input);

            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[$error->getPropertyPath()] = $error->getMessage();
                }

                return new JsonResponse([
                    'status' => 'error',
                    'errors' => $errorMessages,
                ], Response::HTTP_BAD_REQUEST);
            }

            $em->persist($input);
            $em->flush();

            $responseJson = $serializer->serialize($input, 'json');

        } catch (ExceptionInterface $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return JsonResponse::fromJsonString($responseJson);

    }
    #[Route('/funny/input/json', name: 'app_funnyinput_get_json', methods: ['GET'])]
    public function getAll(FunnyInputRepository $repo, SerializerInterface $serializer): JsonResponse
    {
        $funnyInputs = $repo->findAll();

        try {
            $json = $serializer->serialize($funnyInputs, 'json');
        } catch (ExceptionInterface $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return JsonResponse::fromJsonString($json);
    }



}
