<?php

namespace Cartbot\Infrastructure\Controller;

use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\Chat\MessageChat;
use Cartbot\Domain\User\UserChatNotRegisteredException;
use Cartbot\Infrastructure\Services\Assistant\CreateCommand;
use DomainException;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class AssistantNewMessageController extends Controller
{
    private const ID_CLIENT = 1;

    public function newMessage(Request $request, CreateCommand $createCommand, CommandBus $commandBus)
    {
        if (!$this->validate($request->headers)) {
            return new Response();
        }

        try {
            $message = $this->parseMessage($request->getContent());
            $command = $createCommand->create($message);
            $commandBus->handle($command);
        } catch (UserChatNotRegisteredException $ex) {
            return $this->getResponse('Debe identificarse primero usando el enlace indicado al inicio');
        } catch (DomainException $ex) {
            return $this->getResponse($ex->getMessage());
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            return $this->getResponse('Ha ocurrido un error, inténtelo de nuevo en unos instantes');
        }

        $session = new Session();
        return $this->getResponse($session->getFlashBag()->get('response')[0]);

    }

    private function validate(HeaderBag $headers): bool
    {
        return $headers->get('php-auth-user') === $this->getParameter('assistantRequestUser')
            && $headers->get('php-auth-pw') === $this->getParameter('assistantRequestPass');
    }

    private function parseMessage(string $content): MessageChat
    {
        $data = json_decode($content, true);
        if ($data === false || !isset($data['queryResult']['action'])) {
            throw new \Exception('Datos de entrada no validos');
        }

        $product = isset($data['queryResult']['parameters']['product'])
            ? ' ' . trim($data['queryResult']['parameters']['product'])
            : '';

        return new MessageChat(
            trim($data['queryResult']['action']) . $product,
            $data['originalDetectIntentRequest']['payload']['user']['userId'],
            ChatType::createAssistant(),
            self::ID_CLIENT
        );
    }

    private function getResponse(string $textResponse): Response
    {
        return new JsonResponse(['fulfillmentText' => $textResponse]);
    }
}
