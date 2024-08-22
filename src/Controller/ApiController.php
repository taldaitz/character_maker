<?php

namespace App\Controller;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/api/character/{id}', name: 'app_api_character', methods:['GET'])]
    public function getCharacter(Character $character, SerializerInterface $serializer): Response
    { 
        
        $data = $serializer->serialize($character, 'json');
        return new JsonResponse($data, json: true);
    }


    #[Route('/api/character-wins', name: 'app_api_character_wins', methods:['POST'])]
    public function postWinner(Request $request, CharacterRepository $characterRepository, EntityManagerInterface $entityManager): Response
    { 
        $winnerId = $request->get('winner_id');
        $character = $characterRepository->find($winnerId);
        $character->addWin();

        $entityManager->persist($character);
        $entityManager->flush();

        return new Response();
    }

    #[Route('/api/character-looses', name: 'app_api_character_looses', methods:['POST'])]
    public function postLooser(Request $request, CharacterRepository $characterRepository, EntityManagerInterface $entityManager): Response
    { 
        $looserId = $request->get('looser_id');
        $character = $characterRepository->find($looserId);
        $character->addLoss();

        $entityManager->persist($character);
        $entityManager->flush();

        return new Response();
    }
}
