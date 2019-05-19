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
}
