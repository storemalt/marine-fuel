<?php

namespace Tests\Unit;

use App\Helpers\StringHelper;
use Tests\TestCase;

class StringHelperLongestUniqueStringTest extends TestCase
{
    /**
     * A basic unit test example.
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

    public function testEmptyParamsExpectResultEmptyString()
    {
        $word = '';
        $stringHelper = new StringHelper();
        $answer = $stringHelper->longestUniqueString($word);

        $this->assertEmpty($answer);
    }

    public function testUniqueDataExpectsUniqueResultString()
    {
        $word = 'abcd';
        $stringHelper = new StringHelper();
        $answer = $stringHelper->longestUniqueString($word);

        $this->assertSame($word, $answer);
    }
}
