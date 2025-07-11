<?php

namespace GenDiff\Src\Formatters\Json;

function getJson(array $diff): string
{
    if (!is_array($diff)) {
        throw new InvalidArgumentException("Format not correct data. Need 'array'");
    }

    return json_encode($diff);
}
