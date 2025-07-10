<?php

namespace GenDiff\Src\Formatters\Plain;

const PREFIX = '';

function getPlain(array $diff, $prefix = PREFIX)
{
    $result = [];
    foreach ($diff as $key => $item) {
        $fullPath = $prefix ? "$prefix.$key" : $key;
        switch ($item['status']) {
            case 'added':
                $value = formatValue($item['value']);
                $result[] = "Property '$fullPath' was added with value: $value";
                break;
            case 'removed':
                $result[] = "Property '$fullPath' was removed";
                break;
            case 'changed':
                $oldValue = formatValue($item['old_value']);
                $newValue = formatValue($item['new_value']);
                $result[] = "Property '$fullPath' was updated. From $oldValue to $newValue";
                break;
            case 'nested':
                $result[] = getPlain($item['children'], $fullPath);
                break;
            case 'unchanged':
                break;
            default:
                throw new \InvalidArgumentException("Unknown status '{$item['status']}' for property '$fullPath'");
        }
    }
    return implode("\n", $result);
}


function formatValue($val)
{
    if ($val === null) {
        return 'null';
    } elseif ($val === false) {
        return 'false';
    } elseif ($val === true) {
        return 'true';
    } elseif (is_string($val)) {
        return "'$val'";
    } elseif (is_int($val)) {
        return $val;
    } else {
        return '[complex value]';
    }
}
