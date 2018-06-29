<?php

namespace Cartbot\Domain\Services;

interface EventBus
{
    public function handle($event): void;
}
