<?php

namespace GenDiff\Src\Formatters\Plain;

function getPlain(array $diff): string
{
    $plainFormat = getPlainFormat($diff);
    return implode("\n", $plainFormat);
}


function formatValue(mixed $val): string
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
        $fullPath = !empty($prefix) ? "$prefix.$key" : $key;
        $item = $diff[$key];
        switch ($item['status']) {
            case 'added':
                $value = formatValue($item['value']);
                $result = [...$result, "Property '$fullPath' was added with value: $value"];
                break;
            case 'removed':
                $result = [...$result, "Property '$fullPath' was removed"];
                break;
            case 'changed':
                $oldValue = formatValue($item['old_value']);
                $newValue = formatValue($item['new_value']);
                $result = [...$result, "Property '$fullPath' was updated. From $oldValue to $newValue"];
                break;
            case 'nested':
                $nestedResult = getPlainFormat($item['children'], $fullPath);
                $result = [...$result, implode("\n", $nestedResult)];
                break;
            case 'unchanged':
                break;
            default:
                throw new \InvalidArgumentException("Unknown status '{$item['status']}' for property '$fullPath'");
        }
        return $result;
    }, []);
}
