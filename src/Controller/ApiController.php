<?php

namespace App\Controller;

use App\Repository\CharacterRepository;
use JsonSerializable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    #[Route('/api/character-list', name: 'app_api_character_list', methods:['GET'])]
    public function characterList(CharacterRepository $characterRepository, SerializerInterface $serializer): Response
    {
        $characters = $characterRepository->findAll();     
        
        $data = $serializer->serialize($characters, 'json');


        return new JsonResponse($data, json: true);
    }
}
