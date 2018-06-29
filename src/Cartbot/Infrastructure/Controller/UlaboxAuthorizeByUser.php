<?php

namespace Cartbot\Infrastructure\Controller;

use Cartbot\Application\Commands\AuthorizeForClientComm;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UlaboxAuthorizeByUser extends Controller
{
    public function login(Request $request, CommandBus $commandBus)
    {
        $security = $request->request->get('security');
        if ($this->getParameter('ulaboxSecurityAuthCode') !== $security) {
            return new Response();
        }

        $code = $request->request->get('code');
        $token = $request->request->get('token');
        $user = $request->request->get('user');
        $command = new AuthorizeForClientComm($code, $token, $user);
        $commandBus->handle($command);
        return new Response('OK');
    }
}
