<?php

namespace HotlineEmu\DotenvValidator;

final class ExampleFileValidator implements ValidatorInterface
{
    /**
     * @var int
     */
    const FIRST_INSTANCE_OF_DELIMITER = 2;

    /**
     * When exploding, guarantee the value always exists in the key / value pair. Even if it is null.
     *
     * @var array
     */
    const DEFAULT_ARRAY_VALUE = [2 => null];

    /**
     * @var string
     */
    private $exampleFilePath;

    /**
     * @var string
     */
    private $envFilePath;

    public function __construct(string $exampleFilePath, string $envFilePath)
    {
        $this->exampleFilePath = $exampleFilePath;
        $this->envFilePath = $envFilePath;
    }

    /**
     * Validates the environment.
     *
     * @return bool
     */
    public function isValid() : bool
    {
        $exampleFileParsed = $this->parseFileToArray($this->exampleFilePath);
        $envFileParsed = $this->parseFileToArray($this->envFilePath);

        $exampleKeys = array_keys($exampleFileParsed);
        $invalidKeys = [];
        foreach ($exampleKeys as $key) {
            if (array_key_exists($key, $envFileParsed) && trim($envFileParsed[$key]) !== '') {
                continue;
            }

            if (!array_key_exists($key, $envFileParsed)) {
                $invalidKeys[$key] = 'Key is missing from the environment file';
                continue;
            }

            if (trim($envFileParsed[$key]) === '') {
                $invalidKeys[$key] = 'Value is null or resolves to an empty string';
            }
        }

        if (count($invalidKeys)) {
            throw new InvalidEnvironmentException($invalidKeys);
        }

        return true;
    }

    private function parseFileToArray(string $filePath) : array
    {
        $rawFileContents = file_get_contents($filePath);
        $explodedContents = array_filter(explode(PHP_EOL, $rawFileContents));
        $parsedContents = [];
        foreach ($explodedContents as $row) {
            list($key, $value) = explode('=', $row, self::FIRST_INSTANCE_OF_DELIMITER) + self::DEFAULT_ARRAY_VALUE;
            $parsedContents[$key] = $value;
        }

        return $parsedContents;
    }
}
