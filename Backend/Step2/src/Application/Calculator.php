<?php

declare(strict_types=1);

namespace App\Application;

class Calculator
{
    public function multiply(int $a, int $b): int
    {
        return $a * $b;
    }
}
