<?php

namespace Differ\Formatters;

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
    return Plain\getPlain($formatData);
}

function getJsonFormat(array $formatData): string
{
    return Json\getJson($formatData);
}

function getStylishFormat(array $formatData): string
{
    return Stylish\getStylish($formatData);
}
