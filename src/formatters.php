<?php

namespace GenDiff\Src\Formatters;

require __DIR__ . '/../vendor/autoload.php';

function getFormatters(array $result, string $format)
{
    $formatters = [
        'plain' => function ($formatter) {
            return plain\getPlain($formatter);
        },
        'json' => function ($formatter) {
            return json\getJson($formatter);
        },
        'stylish' => function ($formatter) {
            return stylish\getStylish($formatter);
        },
    ];
    return isset($formatters[$format]) ? $formatters[$format]($result) : throw new InvalidArgumentException("Unsupported file extension: $format");
}
