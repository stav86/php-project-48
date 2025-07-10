<?php

namespace GenDiff\Src\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseData($filePath)
{
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    $parsers = [
        'json' => function ($file) {
            $data = json_decode(file_get_contents($file), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException("JSON decode error: " . json_last_error_msg());
            }
            return $data;
        },
        'yaml' => function ($file) {
            return Yaml::parse(file_get_contents($file));
        },
        'yml' => function ($file) {
            return Yaml::parse(file_get_contents($file));
        },
    ];
    $parser = array_values(array_filter(
        $parsers,
        fn ($key) => $key === $extension,
        ARRAY_FILTER_USE_KEY
    ))[0];
    if (!$parser) {
        throw new InvalidArgumentException("Unsupported file extension: $extension");
    }
    if (!is_array($result)) {
        throw new RuntimeException("Parsed data is not an array.");
    }
    return $parser($filePath);
}
