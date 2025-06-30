<?php

namespace GenDiff\Src\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseData($filePath)
{
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    if ($extension === 'json') {
        return json_decode(file_get_contents($filePath), true);
    } elseif ($extension === 'yaml' || $extension === 'yml') {
        return Yaml::parse(file_get_contents($filePath));
    }
}
