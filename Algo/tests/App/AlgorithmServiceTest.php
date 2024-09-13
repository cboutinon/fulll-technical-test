<?php

declare(strict_types=1);

namespace App;

use PHPUnit\Framework\TestCase;

final class AlgorithmServiceTest extends TestCase
{
    /**
     * @dataProvider getNumberProvider
     */
    public function testFizzbuzzResult(int $number, string $resultExpected): void
    {
        $algorithmService = new AlgorithmService();
        $fizzbuzzResult = $algorithmService->fizzBuzz($number);

        self::assertEquals($resultExpected, $fizzbuzzResult);
    }

    /**
     * @dataProvider getWrongNumberProvider
     */
    public function testFizzbuzzWithWrongNumber(int $number, string $exceptionMessage): void
    {
        $algorithmService = new AlgorithmService();

        self::expectExceptionMessage($exceptionMessage);
        $algorithmService->fizzBuzz($number);
    }

    /**
     * @return iterable<string, array<int, int|string>>
     */
    public static function getNumberProvider(): iterable
    {
        yield 'FizzBuzz case' => [15, 'FizzBuzz'];
        yield 'Fizz case' => [9, 'Fizz'];
        yield 'Buzz case' => [10, 'Buzz'];
        yield 'default case' => [1, '1'];
    }

    /**
     * @return iterable<string, array<int, int|string>>
     */
    public static function getWrongNumberProvider(): iterable
    {
        yield 'Zero number' => [0, 'Number must be a positive number'];
        yield 'Negative number' => [-2, 'Number must be a positive number'];
    }
}
