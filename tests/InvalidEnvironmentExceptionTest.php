<?php

namespace HotlineEmuTest\DotenvValidator;

use HotlineEmu\DotenvValidator\InvalidEnvironmentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \HotlineEmu\DotenvValidator\InvalidEnvironmentException
 */
class InvalidEnvironmentExceptionTest extends TestCase
{
    /**
     * @test
     * @covers::__construct
     *
     * @return void
     */
    public function construct()
    {
        $invalidArray = [
            'key_1' => 'value was invalid',
            'key_2' => 'value was invalid',
        ];
        $error = new InvalidEnvironmentException($invalidArray);

        $expectedMessage = "Environment file failed validation\n"
            . "Violations:\n"
            . "key_1: value was invalid\n"
            . "key_2: value was invalid\n";
        $this->assertSame($expectedMessage, $error->getMessage());
    }
}
