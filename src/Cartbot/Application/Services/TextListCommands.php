<?php

namespace Cartbot\Application\Services;

class TextListCommands
{
    public static function getTextListCommands(): string
    {
        return 'Puedes usar los siguientes comandos:' . PHP_EOL
            . 'carrito  -- para listar el carrito' . PHP_EOL
            . 'añadir DESCRIPCION -- para añadir un producto al carrito';
    }
}
