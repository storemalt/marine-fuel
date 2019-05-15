<?php
declare(strict_types=1);

namespace App\Helpers;

class StringHelper
{
    /**
     *
     * @param string $word
     * @return string unique string
     */
    public static function longestUniqueString(string $word): string
    {
        return count_chars($word, 3);
    }

    /**
     * Returns a string of top occurrences in a given string, eg: [4,4,3,2,4]
     * returns 4 as a top occurring value, also accepts number of elements included in the result
     *
     * @param string $numberString
     * @param int $numberOccurrences
     * @return string
     */
    public static function numberOccurrence(string $numberString, int $numberOccurrences = 1): string
    {
        $strippedCommas = trim($numberString, ',');
        $removedSpaces = preg_replace('/\s+/', '', $strippedCommas);
        $arrayConverted = explode(',', $removedSpaces);
        $occurrences = array_count_values($arrayConverted);
        arsort($occurrences, SORT_NUMERIC);
        $topOccurrences = array_slice($occurrences, 0, $numberOccurrences, true);
        $keys = array_keys($topOccurrences);

        return implode(', ', $keys);
    }
}
