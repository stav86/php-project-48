<?php

namespace GenDiff\Src\Formatters;

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

function getPlainFormat($formatData)
{
    return plain\getPlain($formatData);
}
function getJsonFormat($formatData)
{
    return json\getJson($formatData);
}
function getStylishFormat($formatData)
{
    return stylish\getStylish($formatData);
}
