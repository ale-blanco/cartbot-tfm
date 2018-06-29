<?php

namespace UlaboxApi;

use GuzzleHttp\Client;
use UlaboxApi\Actions\Action;
use UlaboxApi\Parser\ErrorParser;

class Sender
{
    private const URL = 'https://api.ulabox.xyz/api/v2/';

    private $client;
    private $apiKey;

    public function __construct(string $ulaboxApiKey)
    {
        $this->client = new Client();
        $this->apiKey = $ulaboxApiKey;
    }

    public function send(Action $action)
    {
        $resul = $this->client->request(
            $action->getMethod()->method(),
            self::URL . $action->getUrl(),
            [
                'http_errors' => false,
                'query' => $this->getQueryParameters($action),
                'json' => $this->getDataParameters($action)
            ]
        );

        if ($resul->getStatusCode() >= 400) {
            ErrorParser::parse((string)$resul->getBody());
        }

        return $action->parseResult((string)$resul->getBody());
    }

    private function getQueryParameters(Action $action): array
    {
        return array_merge(
            ['api_key' => $this->apiKey],
            $action->getQueryData()
        );
    }

    private function getDataParameters(Action $action): ?array
    {
        if (!$action->getMethod()->usePostData()) {
            return null;
        }

        return $action->getPostData();
    }
}
