<?php

namespace App\ValueObjects;

class Money
{
    public function __construct(protected int $cents)
    {
        $this->cents = max(0, $cents);
    }

    public function inDollars(): float
    {
        return $this->cents / 100;
    }

    public function raw(): int
    {
        return $this->cents;
    }

    public function applyDiscount(int $percentage): self
    {
        if ($percentage <= 0 || $percentage >= 100) {
            return $this;
        }

        $discounted = (int) round($this->cents * ((100 - $percentage) / 100));
        return new self($discounted);
    }

    public function formatted(): string
    {
        return number_format($this->inDollars(), 2, '.', '');
    }

    public function __toString(): string
    {
        return $this->formatted();
    }
}
