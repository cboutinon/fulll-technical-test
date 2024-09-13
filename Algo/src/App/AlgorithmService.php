<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

final class AlgorithmService
{
    /**
     * @throws InvalidArgumentException
     */
    public function fizzBuzz(int $number): string
    {
        if ($number < 1) {
            throw new InvalidArgumentException("Number must be a positive number");
        }

        return match (true) {
            ($number % 3 === 0) && ($number % 5 === 0) => 'FizzBuzz',
            $number % 3 === 0 => 'Fizz',
            $number % 5 === 0 => 'Buzz',
            default => (string) $number
        };
    }
}
