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
    

/**#[Route('/api/status', methods: ['GET'])]
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

*/

    #[Route('/api/pico/status', name: 'api_pico_status', methods: ['POST'])]
    public function status(HttpClientInterface $client): JsonResponse
    {
        try {
            $response = $client->request('POST', $this->getParameter('pico_url').'/status', [
                'headers' => [
                    'Connection' => 'close',
                    'Authorization' => 'Bearer '.$this->getParameter('pico_token'),
                ],
            'timeout' => 3,
            'max_duration' => 5,
            'verify_peer' => false,
            'verify_host' => false,
            ]);

            $content = $response->getContent(false);

            return new JsonResponse(
                json_decode($content, true),
                $response->getStatusCode()
            );

        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => 'Pico indisponible',
                'details' => $e->getMessage(),
            ], 503);
        }
    }


    #[Route('/api/pico/vanne2/on', name: 'api_pico_vanne2_on', methods: ['POST'])]
    public function vanne2On(HttpClientInterface $client): JsonResponse
    {

        try {
            $response = $client->request('POST', $this->getParameter('pico_url').'/togglevanne2', [
            'headers' => [
                'Connection' => 'close',
                'Authorization' => 'Bearer '.$this->getParameter('pico_token'),
            ],
            'json' => [
                'state' => true,
            ],
            'timeout' => 3,
            'max_duration' => 5,
            'verify_peer' => false,
            'verify_host' => false,
            ]);
            $content = $response->getContent(false);

            return new JsonResponse(
                json_decode($content, true),
                $response->getStatusCode()
            );

        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => 'Pico indisponible',
                'details' => $e->getMessage(),
            ], 503);
        }

    }


    #[Route('/api/pico/pwm', name: 'api_pico_pwm', methods: ['POST'])]
    public function pwm(Request $request, HttpClientInterface $client): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $pwm = $data['pwm'] ?? null;

            $response = $client->request('POST', 'https://192.168.1.20/pwm', [
                'verify_peer' => false,
                'verify_host' => false,
                'headers' => [
                    'Connection' => 'close',
                    'Authorization' => 'Bearer '.$this->getParameter('pico_token'),
                    'X-PWM' => $pwm,
                ],
                'timeout' => 3,
                'max_duration' => 5,
                'verify_peer' => false,
                'verify_host' => false,
            ]);

            return $this->json([
                'ok' => true,
                'pwm' => $pwm,
            ]);
/**$pwm = (int) $request->headers->get('X-PWM', 0);

            if ($pwm < 0 || $pwm > 3.3) {
                return $this->json([
                    'error' => 'PWM invalide'
                ], 400);
            }

            $response = $client->request('POST', $this->getParameter('pico_url').'/pwm', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->getParameter('pico_token'),
                'X-PWM' => $pwm,
            ],
            'timeout' => 10,
            'max_duration' => 10,
            'verify_peer' => false,
            'verify_host' => false,
            ]);
            $content = $response->getContent(false);

            return new JsonResponse(
                json_decode($content, true),
                $response->getStatusCode()
            );*/

        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => 'Pico indisponible',
                'details' => $e->getMessage(),
            ], 503);
        }
    }


}