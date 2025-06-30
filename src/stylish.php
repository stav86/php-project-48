<?php

namespace GenDiff\Src\Formatter;

require __DIR__ . '/../vendor/autoload.php';
function getIndent($depth, $spacesPerLevel = 4) {
    return str_repeat(' ', $depth * $spacesPerLevel - 2);
}
function getStylish($diff, $depth = 1) {
    $indent = getIndent($depth);
    $result = [];
    foreach ($diff as $key => $item) {
        switch ($item['status']) {
            case 'added':
                $result[] = $indent . "+ " . $key . ": " . formatValue($item['value'], $depth);
                break;
            case 'removed':
                $result[] = $indent . "- " . $key . ": " . formatValue($item['value'], $depth);
                break;
            case 'changed':
                $result[] = $indent . "- " . $key . ": " . formatValue($item['old_value'], $depth);
                $result[] = $indent . "+ " . $key . ": " . formatValue($item['new_value'], $depth);
                break;
            case 'unchanged':
                $result[] = $indent . "  " . $key . ": " . formatValue($item['value'], $depth);
                break;
            case 'nested':
                $result[] = $indent . "  " . $key . ": {";
                $result[] = getStylish($item['children'], $depth + 1);
                $result[] = $indent . "  }";
                break;
        } 
    }

    return "{\n" . implode("\n", $result) . "\n}";
}

function formatValue($value, $depth = 0) {
    if (is_array($value)) {
        $indent = getIndent($depth + 1);
        $closingIndent = getIndent($depth);
        $items = array_map(function($key) use ($value, $indent, $depth) {
            $formattedValue = formatValue($value[$key], $depth + 1);
            return "{$indent}  {$key}: {$formattedValue}";
        }, array_keys($value));
        
        return "{\n" . implode("\n", $items) . "\n{$closingIndent}  }";
    }

    if ($value === false) {
        return 'false';
    } elseif ($value === true) {
        return 'true';
    } 
    return $value === null ? 'null' : $value;
}