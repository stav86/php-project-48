<?php

namespace Differ\Formatters\Plain;

function getPlain(array $diff): string
{
    $plainFormat = getPlainFormat($diff);
    return implode("\n", $plainFormat);
}


function formatValue(mixed $val): mixed
{
    return match (true) {
        $val === null => 'null',
        $val === false => 'false',
        $val === true => 'true',
        is_string($val) => "'$val'",
        is_int($val) => $val,
        default => '[complex value]',
    };
}

function getPlainFormat(array $diff, string $prefix = ''): array
{
    return array_reduce(array_keys($diff), function ($result, $key) use ($diff, $prefix) {
        $fullPath = getFullPath($prefix, $key);
        $item = $diff[$key];
        if ($item['status'] === 'added') {
            $value = formatValue($item['value']);
            return array_merge($result, ["Property '$fullPath' was added with value: $value"]);
        } elseif ($item['status'] === 'removed') {
            return array_merge($result, ["Property '$fullPath' was removed"]);
        } elseif ($item['status'] === 'changed') {
            $oldValue = formatValue($item['old_value']);
            $newValue = formatValue($item['new_value']);
            return array_merge($result, ["Property '$fullPath' was updated. From $oldValue to $newValue"]);
        } elseif ($item['status'] === 'nested') {
            $nestedResult = getPlainFormat($item['children'], $fullPath);
            return array_merge($result, [implode("\n", $nestedResult)]);
        }
        return $result;
    }, []);
}

function getFullPath(string $prefix, string $key): string
{
    return ($prefix !== '') ? "$prefix.$key" : $key;
}
