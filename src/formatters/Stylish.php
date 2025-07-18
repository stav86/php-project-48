<?php

namespace GenDiff\Src\Formatters\Stylish;

const ADDED_PREFIX = '+ ';
const REMOVED_PREFIX = '- ';
const NESTED_PREFIX = '  ';
const CLOSING_BRACE = '  }';
const OPEN_BRACE = ': {';
const COLON = ': ';
const SPECIFIER = '%s';

function getStylish(array $diff, bool $root = true): string
{
    $stylishFormat = getStylishFormat($diff, $root);
    return getBraces($stylishFormat, $root);
}

function getBraces(array $val, bool $root): string
{
    if ($root) {
        return sprintf(
            getSpecifier(SPECIFIER, 3),
            "{\n",
            implode("\n", $val),
            "\n}\n"
        );
    } else {
        return implode("\n", $val);
    }
}

function getStylishFormat(array $diff, bool $root, int $depth = 1): array // @codeCoverageIgnore
{
    $indent = getIndent($depth);
    return array_reduce(array_keys($diff), function ($result, $key) use ($diff, $indent, $depth) {
        $item = $diff[$key];
        if ($item['status'] === 'added') {
            return array_merge(
                $result,
                [sprintf(
                    getSpecifier(SPECIFIER, 5),
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
                    getSpecifier(SPECIFIER, 5),
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
                    getSpecifier(SPECIFIER, 5),
                    $indent,
                    REMOVED_PREFIX,
                    $key,
                    COLON,
                    formatValue($item['old_value'], $depth),
                ),
                sprintf(
                    getSpecifier(SPECIFIER, 5),
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
                    getSpecifier(SPECIFIER, 5),
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
                        getSpecifier(SPECIFIER, 4),
                        $indent,
                        NESTED_PREFIX,
                        $key,
                        OPEN_BRACE,
                    ),
                    implode("\n", $nestedResult),
                    sprintf(
                        getSpecifier(SPECIFIER, 2),
                        $indent,
                        CLOSING_BRACE,
                    )]
                );
        }
        return $result;
    }, []);
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
            getSpecifier(SPECIFIER, 3),
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

function getSpecifier(string $specifier, int $stringQty): string
{
    return str_repeat($specifier, $stringQty);
}

function getIndent(int $depth = 1, int $spacesPerLevel = 4): string
{
    $repSymbol = ' ';
    return str_repeat($repSymbol, $depth * $spacesPerLevel - 2);
}
