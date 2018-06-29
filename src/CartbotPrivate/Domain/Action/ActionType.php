<?php

namespace CartbotPrivate\Domain\Action;

class ActionType
{
    private const PRODUCT_ADDED = 'product_added';
    private const CART_LISTED = 'cart_listed';
    private const NOT_UNDERSTOOD = 'not_understood';
    private const AUTHORIZE_CORRECT = 'authorize_correct';

    private $type;

    public function __construct(string $type)
    {
        if (!in_array($type, self::allTypesString())) {
            throw new ActionTypeNotValidException();
        }

        $this->type = $type;
    }

    public static function allTypesString(): array
    {
        return [self::PRODUCT_ADDED, self::CART_LISTED, self::NOT_UNDERSTOOD, self::AUTHORIZE_CORRECT];
    }

    public static function allTypes(): array
    {
        return [
            self::productAdded(),
            self::cartListed(),
            self::notUnderstood(),
            self::authorizeCorrect()
        ];
    }

    public static function allPrettyTypesString(): array
    {
        return [
            self::productAdded()->prettyType(),
            self::cartListed()->prettyType(),
            self::notUnderstood()->prettyType(),
            self::authorizeCorrect()->prettyType()
        ];
    }

    public static function productAdded(): self
    {
        return new self(self::PRODUCT_ADDED);
    }

    public static function cartListed(): self
    {
        return new self(self::CART_LISTED);
    }

    public static function notUnderstood(): self
    {
        return new self(self::NOT_UNDERSTOOD);
    }

    public static function authorizeCorrect(): self
    {
        return new self(self::AUTHORIZE_CORRECT);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function prettyType(): string
    {
        return [
            self::PRODUCT_ADDED => 'Producto añadido',
            self::CART_LISTED => 'Carrito listado',
            self::NOT_UNDERSTOOD => 'No entendido',
            self::AUTHORIZE_CORRECT => 'Autorizacion ok'
        ][$this->type];
    }

    public function equal(ActionType $type): bool
    {
        return $this->type === $type->type();
    }
}
