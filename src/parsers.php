<?php

namespace GenDiff\Src\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseData($filePath): array
{
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    $parsers = [
        'json' => function ($file) {
            return json_decode(file_get_contents($file), true);
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
    return $parser ? $parser($filePath) : throw new InvalidArgumentException("Unsupported file extension: $extension");
}
