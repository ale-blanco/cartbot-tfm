<?php

namespace Cartbot\Domain\Product;

use Cartbot\Domain\DomainException;

class NotFindedProductException extends DomainException
{
    public function __construct()
    {
        parent::__construct('No se ha encontrado ningun producto');
    }
}
