<?php

namespace App\Controller;

use Cartbot\Domain\User\CustomerToken;
use Cartbot\Infrastructure\Repository\UlaboxTokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

class FakeLogin extends Controller
{
    public function login(Request $request, UlaboxTokenRepository $tokenRepository)
    {
        if ($request->getMethod() !== 'POST') {
            return $this->render('fakelogin.html.twig');
        }

        $customerTokenLogin = new CustomerToken(
            $this->getParameter('customerTokenLogin'),
            new \DateTimeImmutable('-100 days')
        );
        $code = $request->query->get('code');
        $newToken = $tokenRepository->refreshToken($customerTokenLogin);
        $client = new Client();
        $url = $request->server->get('HTTP_ORIGIN') . $this->generateUrl('UlaboxAutorizeByUser');
        $resul = $client->request(
            'POST',
            $url,
            [
                'http_errors' => false,
                'form_params' => [
                    'code' => $code,
                    'token' => $newToken->token(),
                    'user' => 'user',
                    'security' => $this->getParameter('ulaboxSecurityAuthCode')
                ]
            ]
        );
        return new Response('Ok puede volver al chat');
    }
}
