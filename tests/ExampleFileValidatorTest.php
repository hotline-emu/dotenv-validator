<?php

namespace HotlineEmuTest\DotenvValidator;

use HotlineEmu\DotenvValidator\ExampleFileValidator;
use HotlineEmu\DotenvValidator\InvalidEnvironmentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \HotlineEmu\DotenvValidator\ExampleFileValidator
 * @covers ::__construct()
 * @covers ::<private>
 */
class ExampleFileValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private $exampleFilePath;

    /**
     * @var string
     */
    private $isValidFilePath;

    public function setUp()
    {
        parent::setUp();
        $this->exampleFilePath = __DIR__ . '/_files/.env.example';
    }

    /**
     * @test
     * @dataProvider isValidProvider
     * @covers ::isValid
     *
     * @param bool   $expectSuccess    The expected result for isValid().
     * @param string $testFilePath     The env file path to test against.
     * @param string $exceptionMessage The expected exception message, if $expectation is true.
     *
     * @return void
     */
    public function isValid(bool $expectSuccess, string $testFilePath, string $exceptionMessage = '')
    {
        if ($expectSuccess === false) {
            $this->expectException(InvalidEnvironmentException::class);
            $this->expectExceptionMessage($exceptionMessage);
        }

        $validator = new ExampleFileValidator($this->exampleFilePath, $testFilePath);
        $this->assertSame($expectSuccess, $validator->isValid());
    }

    public function isValidProvider() : array
    {
        return [
            'basic' => [
                'expectation' => true,
                'testFilePath' => __DIR__ . '/_files/.env.isValid',
            ],
            'key missing' => [
                'expectation' => false,
                'testFilePath' => __DIR__ . '/_files/.env.keyMissing',
                'exceptionMessage' => "VARIABLE_2: Key is missing from the environment file\n",
            ],
            'key is empty' => [
                'expectation' => false,
                'testFilePath' => __DIR__ . '/_files/.env.keyIsEmpty',
                'exceptionMessage' => "VARIABLE_2: Value is null or resolves to an empty string\n",
            ],
            'key is empty string' => [
                'expectation' => false,
                'testFilePath' => __DIR__ . '/_files/.env.keyIsEmptyString',
                'exceptionMessage' => "VARIABLE_2: Value is null or resolves to an empty string\n",
            ],
        ];
    }
}
