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

function parseJson(string $pathFile): mixed
{
    if (!file_exists($pathFile)) {
        throw new InvalidArgumentException("File not found '$pathFile'");
    }

    $fileContent = file_get_contents($pathFile);

    if ($fileContent === false) {
        throw new InvalidArgumentException("Unknown data: '$pathFile'");
    }

    return json_decode($fileContent, true, JSON_THROW_ON_ERROR);
}

function parseYaml(string $pathFile): mixed
{
    if (!file_exists($pathFile)) {
        throw new InvalidArgumentException("File not found '$pathFile'");
    }

    $fileContent = file_get_contents($pathFile);

    if ($fileContent === false) {
        throw new InvalidArgumentException("Unknown data: '$pathFile'");
    }

    return Yaml::parse($fileContent, Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE);
}
