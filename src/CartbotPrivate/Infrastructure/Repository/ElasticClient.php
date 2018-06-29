<?php

namespace CartbotPrivate\Infrastructure\Repository;

use Elastica\Client;

class ElasticClient extends Client
{
    public function __construct(string $host_elastic)
    {
        parent::__construct(
            [
                'host' => $host_elastic
            ]
        );
    }
}
