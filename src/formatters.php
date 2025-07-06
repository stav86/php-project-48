<?php

namespace GenDiff\Src\Formatters;

function getFormatters($result, $format)
{
    if ($format == 'plain') {
        return plain\getPlain($result);
    } elseif ($format == 'json') {
        return json\getJson($result);
    } else {
        return stylish\getStylish($result);
    }
}
 