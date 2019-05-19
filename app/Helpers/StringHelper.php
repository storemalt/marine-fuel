<?php
declare(strict_types=1);

namespace App\Helpers;

class StringHelper
{
    public function longestUniqueString(string $word): string
    {
        return count_chars($word, 3);
    }

    public function stripCommas(string $string)
    {
        return trim($string, ',');
    }

    public function removeSpaces(string $string)
    {
        return preg_replace('/\s+/', '', $string);
    }

    public function stringToArray(string $string)
    {
        return explode(',', $string);
    }

    public function countOccurrences(array $array)
    {
        return array_count_values($array);
    }

    public function assocReverseSortNumeric(array $array)
    {
        arsort($array, SORT_NUMERIC);

        return $array;
    }

    public function topOccurrences(array $occurrences, int $requiredMinOccurrences)
    {
        return array_slice($occurrences, 0, $requiredMinOccurrences, true);
    }

    public function getKeys(array $array)
    {
        return array_keys($array);
    }

    public function arrayToStringWithSpace(array $array)
    {
        return implode(', ', $array);
    }

    /**
     * Returns a string of top occurrences in a given string, eg: [4,4,3,2,4]
     * returns 4 as a top occurring value, also accepts number of elements included in the result
     *
     * @param string $numberString
     * @param int $numberOccurrences
     * @return string
     */
    public function occurrence(string $numberString, int $numberOccurrences = 1): string
    {
        // ensure that number occurrence required is always 1
        if ($numberOccurrences < 1) {
            $numberOccurrences = 1;
        }

        $strippedCommas = $this->stripCommas($numberString);
        $removedSpaces = $this->removeSpaces($strippedCommas);
        $arrayConverted = $this->stringToArray($removedSpaces);
        $occurrences = $this->countOccurrences($arrayConverted);
        $occurrences = $this->assocReverseSortNumeric($occurrences);
        $topOccurrences = $this->topOccurrences($occurrences, $numberOccurrences);
        $keys = $this->getKeys($topOccurrences);

        return $this->arrayToStringWithSpace($keys);
    }

}
