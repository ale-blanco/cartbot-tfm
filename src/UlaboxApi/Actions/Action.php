<?php

namespace UlaboxApi\Actions;

use UlaboxApi\Http\Method;

interface Action
{
    public function getMethod(): Method;

    public function getUrl(): string;

    public function getQueryData(): array;

    public function getPostData(): array;

    public function parseResult(string $response);
}