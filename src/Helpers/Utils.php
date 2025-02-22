<?php

use Spatie\LaravelData\{DataCollection, Optional};
use Homeful\Common\Classes\DocStamps;
use Illuminate\Support\Str;

if (! function_exists('documents_path')) {
    function documents_path(?string $path = null): string
    {
        $documents_path = base_path('resources/documents');

        return $documents_path.($path ? '/'.$path : '');
    }
}

if (! function_exists('formatted_age')) {
    /**
     * Display age in format:
     * '%y years, %m months and %d days old'
     * '%y years and %m months old'
     * '%m years and %d days old'
     *
     * @param \DateTime $born
     * @param DateTime|null $reference
     * @return string
     *
     */
    function formatted_age(DateTime $born, ?DateTime $reference = null): string
    {
        $reference = $reference ?: new DateTime;

        if ($born > $reference)
            throw new \InvalidArgumentException('Provided birthday cannot be in future compared to the reference date.');

        $diff = $reference->diff($born);

        // Not very readable, but all it does is joining age
        // parts using either ',' or 'and' appropriately

        $age = ($d = $diff->d) ? ' and '.$d.' '. Str::plural('day', $d) : '';
        $age = ($m = $diff->m) ? ($age ? ', ' : ' and ').$m.' '. Str::plural('month', $m) . $age : $age;
        $age = ($y = $diff->y) ? $y.' '. Str::plural('year', $y) . $age  : $age;

        // trim redundant ',' or 'and' parts
        return ($s = trim(trim($age, ', '), ' and ')) ? $s.' old' : 'newborn';
    }
}

if (! function_exists('doc_stamps')) {
    function doc_stamps(mixed $value): float
    {
        return (new DocStamps($value))->getPrice()->inclusive()->getAmount()->toFloat();
    }
}

if (!function_exists('filter_trim_recursive_array')) {
    function filter_trim_recursive_array($array = []): array
    {
        $callback = function ($item) {
            if (is_array($item)) {
                return filter_trim_recursive_array($item);
            } elseif (is_string($item)) {
                return trim($item);
            }
            return $item;
        };

        $array = array_map($callback, $array);
        return array_filter($array);
    }
}

if (!function_exists('dot_shift')) {
    function dot_shift(&$dot_notation): string
    {
        $parts = explode('.', $dot_notation, 2); // Split into two parts
        $dot_notation = $parts[1] ?? ''; // Update to remaining part or empty

        return $parts[0]; // Return the first element
    }
}

if (!function_exists('titleCase')) {
    function titleCase(?string $text, array $exclusions = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV']): string
    {
        if (empty($text)) {
            return '';
        }

        $titleCased = Str::title($text);

        // Restore the Roman numerals to their original case
        return preg_replace_callback(
            '/\b(' . implode('|', $exclusions) . ')\b/i',
            fn($matches) => strtoupper($matches[0]),
            $titleCased
        );
    }
}

if (!function_exists('validateJson')) {
    function validateJson(string $json): bool
    {
        return filter_var(
            $json,
            FILTER_CALLBACK,
            ['options' => function ($value) {
                if (!is_string($value) || trim($value) === '') {
                    return false; // Ensure it's a non-empty string before validation
                }

                json_decode($value);
                return json_last_error() === JSON_ERROR_NONE;
            }]
        );
    }
}

if (!function_exists('resolveOptionalCollection')) {
    /**
     * Resolves an optional Spatie DataCollection.
     * Converts the DataCollection to an Eloquent collection if present, otherwise returns an empty collection.
     *
     * @param DataCollection|Optional|null $collection The collection to resolve.
     * @return \Illuminate\Support\Collection The resolved collection or an empty collection.
     */
    function resolveOptionalCollection(DataCollection|Optional|null $collection): \Illuminate\Support\Collection
    {
        return $collection && !($collection instanceof Optional)
            ? $collection->toCollection()
            : collect();
    }
}

/**
 * Conditionally transform an array.
 *
 * @param array    $array    The array to transform.
 * @param mixed    $condition If truthy, the callback will be executed.
 * @param callable $callback  The transformation callback that receives the array.
 *
 * @return array The transformed array if condition is truthy, otherwise the original array.
 */

if (!function_exists('array_when')) {
    function array_when(array $array, $condition, callable $callback): array {
        return $condition ? $callback($array) : $array;
    }

// Usage:
    $array = [1, 2, 3];
    $result = array_when($array, false, function ($arr) {
        return array_map(fn($item) => $item * 2, $arr);
    });
// $result remains [1, 2, 3]
}
