<?php

namespace Differ\Differ;

use InvalidArgumentException;

use function Funct\Collection\sortBy;
use function GenDiff\Src\Parsers\parseData;
use function GenDiff\Src\Formatters\getFormatters;

const ADD = 'added';
const REMOVE = 'removed';
const UNCHANGED = 'unchanged';
const NESTED = 'nested';
const CHANGED = 'changed';

function genDiff(
    string $toPathFile1,
    string $toPathFile2,
    string $format = 'stylish'
): string {
    $extensionFile1 = getExtension($toPathFile1);
    $extensionFile2 = getExtension($toPathFile2);
    $parseFile1 = parseData($extensionFile1, $toPathFile1);
    $parseFile2 = parseData($extensionFile2, $toPathFile2);
    $buildDiff = getDiff($parseFile1, $parseFile2);
    return getFormatters($buildDiff, $format);
}

function getDiff(array $data1, array $data2): array
{
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    $sortedKeys = sortBy($keys, fn($key) => $key);
    return array_reduce($sortedKeys, function ($result, $key) use ($data1, $data2) {
        if (!array_key_exists($key, $data1)) {
            return array_merge(
                $result,
                [$key => ['status' => ADD,
                'value' => $data2[$key]]]
            );
        } elseif (!array_key_exists($key, $data2)) {
            return array_merge(
                $result,
                [$key => ['status' => REMOVE,
                'value' => $data1[$key]]]
            );
        } elseif (is_array($data1[$key]) && is_array($data2[$key])) {
            return array_merge(
                $result,
                [
                $key => ['status' => NESTED,
                'children' => getDiff($data1[$key], $data2[$key])]]
            );
        } elseif ($data1[$key] !== $data2[$key]) {
            return array_merge(
                $result,
                [
                    $key => [
                'status' => CHANGED,
                'old_value' => $data1[$key],
                'new_value' => $data2[$key],
                        ]]
            );
        } else {
            return array_merge(
                $result,
                [$key => ['status' => UNCHANGED,
                'value' => $data1[$key]]]
            );
        }
        return $result;
    }, []);
}

function getExtension(string $toPathFile): string
{
    return pathinfo($toPathFile, PATHINFO_EXTENSION);
}
