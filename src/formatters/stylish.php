<?php

namespace GenDiff\Src\Formatters\Stylish;

const ADDED_PREFIX = '+ ';
const REMOVED_PREFIX = '- ';
const NESTED_PREFIX = '  ';
const CLOSING_BRACE = '  }';
const OPEN_BRACE = ': {';
const COLON = ': ';

function getStylish(array $diff, bool $root = true): string
{
    $stylishFormat = getStylishFormat($diff, $root);
    return getBraces($stylishFormat, $root);
}

function formatValue(mixed $value, int $depth = 1): string
{
    if (is_array($value)) {
        $indent = getIndent($depth + 1);
        $closingIndent = getIndent($depth);
        $items = array_map(function ($key) use ($value, $indent, $depth) {
            $formattedValue = formatValue($value[$key], $depth + 1);
            return "$indent  $key: $formattedValue";
        }, array_keys($value));
        return sprintf(
            '%s%s%s',
            "{\n",
            implode("\n", $items),
            "\n{$closingIndent}  }",
        );
    }

    return match ($value) {
        false => 'false',
        true => 'true',
        null => 'null',
        default => $value,
    };
}

function getIndent(int $depth = 1, int $spacesPerLevel = 4): string
{
    $repSymbol = ' ';
    return str_repeat($repSymbol, $depth * $spacesPerLevel - 2);
}

function getBraces(array $val, bool $root): string
{
    if ($root) {
        return sprintf(
            "%s%s%s",
            "{\n",
            implode("\n", $val),
            "\n}\n"
        );
    } else {
        return implode("\n", $val);
    }
}

function getStylishFormat(array $diff, bool $root = true, int $depth = 1): array
{
    $indent = getIndent($depth);
    return array_reduce(array_keys($diff), function ($result, $key) use ($diff, $indent, $depth) {
        $item = $diff[$key];
        if ($item['status'] === 'added') {
            return array_merge(
                $result,
                [sprintf(
                    '%s%s%s%s%s',
                    $indent,
                    ADDED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['value'], $depth),
                )]
            );
        } elseif ($item['status'] === 'removed') {
            return array_merge(
                $result,
                [sprintf(
                    '%s%s%s%s%s',
                    $indent,
                    REMOVED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['value'], $depth),
                )]
            );
        } elseif ($item['status'] === 'changed') {
            return array_merge(
                $result,
                [sprintf(
                    '%s%s%s%s%s',
                    $indent,
                    REMOVED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['old_value'], $depth),
                ),
                sprintf(
                    '%s%s%s%s%s',
                    $indent,
                    ADDED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['new_value'], $depth),
                )]
            );
        } elseif ($item['status'] === 'unchanged') {
            return array_merge(
                $result,
                [sprintf(
                    '%s%s%s%s%s',
                    $indent,
                    NESTED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['value'], $depth)
                )]
            );
        } elseif ($item['status'] === 'nested') {
            $nestedResult = getStylishFormat($item['children'], false, $depth + 1);
                return array_merge(
                    $result,
                    [sprintf(
                        '%s%s%s%s',
                        $indent,
                        NESTED_PREFIX,
                        $key,
                        OPEN_BRACE,
                    ),
                    implode("\n", $nestedResult),
                    sprintf(
                        '%s%s',
                        $indent,
                        CLOSING_BRACE,
                    )]
                );
        }
        return $result;
    }, []);
}
