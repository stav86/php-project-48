<?php

namespace GenDiff\Src\Parsers;

use Symfony\Component\Yaml\Yaml;

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

function parseJson($pathFile)
{
    return json_decode(file_get_contents($pathFile), true);
}

function parseYaml($pathFile)
{
    return Yaml::parse(file_get_contents($pathFile));
}
