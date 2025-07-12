<?php

namespace GenDiff\Src\Parsers;

use Symfony\Component\Yaml\Yaml;
use InvalidArgumentException;

const JSON = 'json';
const YAML = 'yaml';
const YML = 'yml';

function parseData(string $extension, string $toPathFile): array
{
    return match ($extension) {
        JSON => parseJson($toPathFile),
        YAML => parseYaml($toPathFile),
        YML => parseYaml($toPathFile),
        default => throw new InvalidArgumentException("Unknown extension: '$extension'"),
    };
}

function parseJson(string $pathFile): array
{
    return json_decode(file_get_contents($pathFile, JSON_THROW_ON_ERROR), true);
}

function parseYaml(string $pathFile): array
{
    return Yaml::parse(file_get_contents($pathFile, Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE));
}
