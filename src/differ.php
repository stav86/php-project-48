<?php

namespace GenDiff\Src\Differ;

function format($data)
{
    if (is_string($data)) {
        return $data;
    } elseif (is_bool($data)) {
        return $data ? 'true' : 'false';
    }
    return $data;
}

function genDiff($firstFileData, $secondFileData)
{
    $keys = array_unique(array_merge(array_keys($firstFileData), array_keys($secondFileData)));
    sort($keys);
    $diff = [];

    foreach ($keys as $key) {
        if (array_key_exists($key, $firstFileData) && array_key_exists($key, $secondFileData)) {
            if ($firstFileData[$key] === $secondFileData[$key]) {
                $diff[] = "  $key: " . format($firstFileData[$key]);
            } else {
                $diff[] = "- $key: " . format($firstFileData[$key]);
                $diff[] = "+ $key: " . format($secondFileData[$key]);
            }
        } elseif (array_key_exists($key, $firstFileData)) {
            $diff[] = "- $key: " . format($firstFileData[$key]);
        } elseif (array_key_exists($key, $secondFileData)) {
            $diff[] = "+ $key: " . format($secondFileData[$key]);
        }
    }

    return implode("\n", $diff) . "\n";
}
