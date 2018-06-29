<?php

namespace Cartbot\Infrastructure\Controller;

use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\Chat\MessageChat;
use Cartbot\Domain\DomainException;
use Cartbot\Domain\User\UserChatNotRegisteredException;
use Cartbot\Infrastructure\Services\Telegram\CreateCommand;
use Cartbot\Infrastructure\Services\Telegram\SendResponse;

class TelegramNewMessageController extends Controller
{
    private const ID_CLIENT = '1';

    public function newMessage(
        Request $request,
        CreateCommand $createCommand,
        CommandBus $commandBus,
        SendResponse $sendResponse
    ): Response {
        $request = json_decode($request->getContent(), true);
        $message = $this->parseMessage($request);
        try {
            $command = $createCommand->create($message);
            $commandBus->handle($command);
        } catch (UserChatNotRegisteredException $ex) {
            $sendResponse->send(
                $message->idUser(),
                'Debe identificarse primero usando el enlace indicado al inicio o indique /start.'
            );
        } catch (DomainException $ex) {
            $sendResponse->send($message->idUser(), $ex->getMessage());
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            $sendResponse->send($message->idUser(), 'Ups, ha ocurrido un error, intentelo de nuevo en unos instantes');
        }
        return new Response();
    }

    private function parseMessage(array $data): MessageChat
    {
        if (!isset($data['message']['text'])) {
            throw new \Exception('Datos de entrada no validos');
        }

        return new MessageChat(
            trim($data['message']['text']),
            $data['message']['chat']['id'],
            ChatType::createTelegam(),
            self::ID_CLIENT
        );
    }
}
