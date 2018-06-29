<?php

namespace CartbotPrivate\Domain\Action;

use CartbotPrivate\Domain\ValidateException;

class SortActions
{
    private const ASC = '+';
    private const DESC = '-';
    private const KEYS = [
        'date' => 'date',
        'user' => 'idUser',
        'chat' => 'chatType.keyword',
        'type' => 'type',
        'description' => 'data.keyword'
    ];

    private $direction;
    private $key;

    public function __construct(string $order)
    {
        if (!in_array($order, $this->validsValues())) {
            throw new ValidateException('order', 'Valor no valido');
        }

        $this->direction = (substr($order, 0, 1) === self::ASC) ? 'asc' : 'desc';
        $this->key = str_replace(array_keys(self::KEYS), array_values(self::KEYS), substr($order, 1));
    }

    public function direction(): string
    {
        return $this->direction;
    }

    public function key(): string
    {
        return $this->key;
    }

    private function validsValues(): array
    {
        $keys = array_keys(self::KEYS);
        return array_merge(
            array_map(function ($item) {
                return self::ASC . $item;
            }, $keys),
            array_map(function ($item) {
                return self::DESC . $item;
            }, $keys)
        );
    }
}
