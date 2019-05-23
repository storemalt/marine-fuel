<?php

namespace Tests\Unit;

use App\Helpers\StringHelper;
use Tests\TestCase;

class StringHelperLongestUniqueStringTest extends TestCase
{
    /**
     * Checks if a non unique data will result to a unique string
     *
     * @return void
     */
    public function testNonUniqueDataExpectsUniqueResultString()
    {
        $word = 'aabbccdd';
        $stringHelper = new StringHelper();
        $answer = $stringHelper->longestUniqueString($word);

        $this->assertIsString($answer);
        $this->assertEquals(4, strlen($answer));
    }

    /**
     * Checks empty data results in an empty result data
     *
     * @return void
     */
    public function testEmptyParamsExpectResultEmptyString()
    {
        $word = '';
        $stringHelper = new StringHelper();
        $answer = $stringHelper->longestUniqueString($word);

        $this->assertEmpty($answer);
    }

    /**
     * Checks if a unique data will result to the same string
     *
     * @return void
     */
    public function testUniqueDataExpectsUniqueResultString()
    {
        $word = 'abcd';
        $stringHelper = new StringHelper();
        $answer = $stringHelper->longestUniqueString($word);

        $this->assertSame($word, $answer);
    }

    /**
     * Checks if a unique reversed data will result to a sorted string
     *
     * @return void
     */
    public function testReversedUniqueDataExpectsUniqueResultStringSorted()
    {
        $word = 'dcba';
        $stringHelper = new StringHelper();
        $answer = $stringHelper->longestUniqueString($word);
        $answer = strrev($answer);
        $this->assertSame($word, $answer);
    }
}
