<?php

namespace GenDiff\Src\Formatters;

use InvalidArgumentException;

const PLAIN = 'plain';
const JSON = 'json';
const STYLISH = 'stylish';

function getFormatters(array $result, string $format): string
{
    return match ($format) {
        PLAIN => getPlainFormat($result),
        JSON => getJsonFormat($result),
        STYLISH => getStylishFormat($result),
        default => throw new InvalidArgumentException("Unknown format: '$format'"),
    };
}

function getPlainFormat(array $formatData): string
{
    return plain\getPlain($formatData);
}
function getJsonFormat(array $formatData): string
{
    return json\getJson($formatData);
}
function getStylishFormat(array $formatData): string
{
    return stylish\getStylish($formatData);
}
