<?php

namespace UlaboxApi\Models;

class CompactCartResponse
{
    private $total;
    private $totalPoducts;

    public function __construct(float $total, int $totalPoducts)
    {
        $this->total = $total;
        $this->totalPoducts = $totalPoducts;
    }

    public function balance(): float
    {
        return $this->total;
    }

    public function totalPoducts(): int
    {
        return $this->totalPoducts;
    }
}
