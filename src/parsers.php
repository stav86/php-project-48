<?php

namespace GenDiff\Src\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseData($input)
{
    if (is_string($input)) {
        if (file_exists($input)) {
            $extension = pathinfo($input, PATHINFO_EXTENSION);
            $data = file_get_contents($input);
        } else {
            $data = $input;
            $extension = 'json';
        }
    } else {
        throw new InvalidArgumentException("Input must be a string.");
    }
    $parsers = [
        'json' => function ($data) {
            $decodedData = json_decode($data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException("JSON decode error: " . json_last_error_msg());
            }
            return $decodedData;
        },
        'yaml' => function ($data) {
            return Yaml::parse($data);
        },
        'yml' => function ($data) {
            return Yaml::parse($data);
        },
    ];
    if (!array_key_exists($extension, $parsers)) {
        throw new InvalidArgumentException("Unsupported file extension: $extension");
    }
    $result = $parsers[$extension]($data);
    if (!is_array($result)) {
        throw new RuntimeException("Parsed data is not an array.");
    }
    return $result;
}
