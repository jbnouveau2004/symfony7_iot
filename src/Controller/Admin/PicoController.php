<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use Symfony\Component\HttpFoundation\Request;



class PicoController extends AbstractController
{

    /**
     * @var Environment
     */
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }
    
    #[Route('/admin/pico/status', name: 'admin_pico_status', methods: ['POST'])]
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


    #[Route('/admin/pico/vanne2/on', name: 'admin_pico_vanne2_on', methods: ['POST'])]
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
    


    #[Route('/admin/pico/voltage', name: 'admin_pico_voltage', methods: ['POST'])]
    public function voltage(HttpClientInterface $client): JsonResponse
    {
        try {
            $response = $client->request('POST', $this->getParameter('pico_url').'/voltage', [
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


    #[Route('/admin/pico/pwm', name: 'admin_pico_pwm', methods: ['POST'])]
    public function pwm(Request $request, HttpClientInterface $client): JsonResponse
    {
        try {
            $pwm = (int) $request->headers->get('X-PWM', 0);

            if ($pwm < 0 || $pwm > 3.3) {
                return $this->json([
                    'error' => 'PWM invalide'
                ], 400);
            }

            $response = $client->request('POST', $this->getParameter('pico_url').'/pwm', [
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



}