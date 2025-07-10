<?php

namespace GenDiff\Src\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseData($input)
{
    if (is_array($input)) {
        return $input;
    }
    if (file_exists($input)) {
        $extension = pathinfo($input, PATHINFO_EXTENSION);
        $data = file_get_contents($input);
    } else {
        $data = $input;
        $extension = 'json';
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
        return [$data];
    }
    $result = $parsers[$extension]($data);
    if (!is_array($result)) {
        return [$result];
    }
    return $result;
}
