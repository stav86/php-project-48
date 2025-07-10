<?php

namespace GenDiff\Src\Formatters\Stylish;

const SPACES_PER_LEVEL = 4;
const ADDED_PREFIX = '+ ';
const REMOVED_PREFIX = '- ';
const NESTED_PREFIX = '  ';
const CLOSING_BRACE = '  }';
const OPEN_BRACE = ': {';
const COLON = ': ';
const DEPTH = 1;

function getStylish(array $diff, int $depth = DEPTH, bool $root = true): string
{
    $indent = getIndent($depth);
    $result = [];
    foreach ($diff as $key => $item) {
        switch ($item['status']) {
            case 'added':
                $result[] = sprintf(
                    '%s%s%s%s%s',
                    $indent,
                    ADDED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['value'], $depth),
                );
                break;
            case 'removed':
                $result[] = sprintf(
                    '%s%s%s%s%s',
                    $indent,
                    REMOVED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['value'], $depth),
                );
                break;
            case 'changed':
                $result[] = sprintf(
                    '%s%s%s%s%s',
                    $indent,
                    REMOVED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['old_value'], $depth),
                );
                $result[] = sprintf(
                    '%s%s%s%s%s',
                    $indent,
                    ADDED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['new_value'], $depth),
                );
                break;
            case 'unchanged':
                $result[] = sprintf(
                    '%s%s%s%s%s',
                    $indent,
                    NESTED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['value'], $depth)
                );
                break;
            case 'nested':
                $result[] = sprintf(
                    '%s%s%s%s',
                    $indent,
                    NESTED_PREFIX,
                    $key,
                    OPEN_BRACE,
                );
                $result[] = sprintf(
                    '%s',
                    getStylish($item['children'], $depth + 1, false),
                );
                $result[] = sprintf(
                    '%s%s',
                    $indent,
                    CLOSING_BRACE,
                );
                break;
            default:
                throw new \InvalidArgumentException("Unknown status '{$item['status']}'");
        }
    }
    if ($root) {
        return sprintf(
            '%s%s%s',
            "{\n",
            implode("\n", $result),
            "\n}\n",
        );
    } else {
        return implode("\n", $result);
    }
}

function formatValue($value, int $depth = DEPTH): string
{
    if (is_array($value)) {
        $indent = getIndent($depth + 1);
        $closingIndent = getIndent($depth);
        $items = array_map(function ($key) use ($value, $indent, $depth) {
            $formattedValue = formatValue($value[$key], $depth + 1);
            return "{$indent}  {$key}: {$formattedValue}";
        }, array_keys($value));
        return sprintf(
            '%s%s%s',
            "{\n",
            implode("\n", $items),
            "\n{$closingIndent}  }",
        );
    }

    if ($value === false) {
        return 'false';
    } elseif ($value === true) {
        return 'true';
    } elseif ($value === null) {
        return 'null';
    } else {
        return $value;
    }
}

function getIndent(int $depth = DEPTH, int $spacesPerLevel = SPACES_PER_LEVEL)
{
    return str_repeat(' ', $depth * $spacesPerLevel - 2);
}
