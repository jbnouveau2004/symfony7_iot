<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use Symfony\Component\HttpFoundation\Request;

class APIController extends AbstractController
{

    public function __construct()
    {

    }
    

#[Route('/api/status', methods: ['GET'])]
public function status(): JsonResponse
{
    return $this->json([
        'message' => 'API OK',
        'user' => $this->getUser()?->getUserIdentifier(),
    ]);
}

#[Route('/api/pico/commande', methods: ['POST'])]
public function commande(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    return $this->json([
        'message' => 'Commande reçue',
        'data' => $data,
        'user' => $this->getUser()?->getUserIdentifier(),
    ]);
}



}