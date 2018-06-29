<?php

namespace CartbotPrivate\Application\CommandHandlers\Admin;

use CartbotPrivate\Application\Outputs\Admin\OkOut;
use CartbotPrivate\Domain\Services\PasswordChecker;
use CartbotPrivate\Domain\Services\PasswordEncoder;
use CartbotPrivate\Domain\User\PasswordEqualActualException;
use CartbotPrivate\Domain\User\PasswordNotValidException;
use CartbotPrivate\Domain\User\PasswordPlainText;
use CartbotPrivate\Domain\User\UserClient;
use CartbotPrivate\Domain\User\UserClientRepository;

class ChangePass
{
    private $checker;
    private $userClientRepository;
    private $encoder;

    public function __construct(
        PasswordChecker $checker,
        PasswordEncoder $encoder,
        UserClientRepository $userClientRepository
    ) {
        $this->checker = $checker;
        $this->userClientRepository = $userClientRepository;
        $this->encoder = $encoder;
    }

    public function __invoke(PasswordPlainText $actualPass, PasswordPlainText $newPass, UserClient $user): OkOut
    {
        if ($actualPass->equal($newPass)) {
            throw new PasswordEqualActualException();
        }

        if (!$this->checker->isValid($actualPass, $user)) {
            throw new PasswordNotValidException();
        }

        $user->setPassword($this->encoder->encode($user, $newPass->password()));
        $this->userClientRepository->save($user);
        return new OkOut();
    }
}
