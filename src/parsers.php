<?php

namespace GenDiff\Src\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseData($filePath, $toPathFile)
{
    if ($filePath === 'json') {
        return json_decode(file_get_contents($toPathFile), true);
    } elseif ($filePath === 'yaml' || $filePath === 'yml') {
        return Yaml::parse(file_get_contents($toPathFile));
    }
}
