<?php

namespace Differ\Differ;

use function Funct\Collection\sortBy;

const STYLISH = 'stylish';

function genDiff($data1, $data2, $format = STYLISH): array
{
    if (!is_array($data1) || !is_array($data2)) {
        throw new \InvalidArgumentException("Incorrect format");
    }
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    $sortedKeys = sortBy($keys, fn($key) => $key);
    return array_reduce($sortedKeys, function ($result, $key) use ($data1, $data2) {
        if (!array_key_exists($key, $data1)) {
            $result[$key] = ['status' => 'added', 'value' => $data2[$key]];
        } elseif (!array_key_exists($key, $data2)) {
            $result[$key] = ['status' => 'removed', 'value' => $data1[$key]];
        } elseif (is_array($data1[$key]) && is_array($data2[$key])) {
            $result[$key] = ['status' => 'nested', 'children' => genDiff($data1[$key], $data2[$key])];
        } elseif ($data1[$key] !== $data2[$key]) {
            $result[$key] = [
                'status' => 'changed',
                'old_value' => $data1[$key],
                'new_value' => $data2[$key],
            ];
        } else {
            $result[$key] = ['status' => 'unchanged', 'value' => $data1[$key]];
        }
        return $result;
    }, []);
}
