<?php

namespace Tests\Unit;

use App\Helpers\StringHelper;
use Tests\TestCase;

class StringHelperOccurrenceTest extends TestCase
{
    /**
     * Tests the string helper occurrence method
     * Given a correct string data will result to an expected correct comma separated string value
     *
     * @return void
     */
    public function testCommaSeparatedValuesDataExpectsStringAndCorrectResult()
    {
        $arrayValues = '1, 2, 2, 3, 3, 3, 4, 4, 4, 4';
        $minNumberOfOccurrence = 2;
        $stringHelper = new StringHelper();
        $answer = $stringHelper->occurrence(
            $arrayValues,
            $minNumberOfOccurrence
        );
        $this->assertIsString($answer);
        $this->assertSame('4, 3', $answer);
    }

    /**
     * Passing a single comma to the method expects empty string as result
     *
     * @return void
     */
    public function testOneCommaDataExpectsEmptyResult()
    {
        $commaSeparatedValues = ',';
        $stringHelper = new StringHelper();
        $answer = $stringHelper->occurrence($commaSeparatedValues);

        $this->assertEmpty($answer);
    }

    /**
     * Passing data and minimum of 2 occurrences expects a string with two values
     *
     * @return void
     */
    public function testWithMinimumTwoOccurrencesExpectTwoValuesAsResult()
    {
        $commaSeparatedValues = '1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3';
        $numberOfMinimumOccurrences = 2;
        $stringHelper = new StringHelper();
        $answer = $stringHelper->occurrence(
            $commaSeparatedValues,
            $numberOfMinimumOccurrences
        );

        $arrayCount = explode(',', $answer);
        $this->assertCount(2, $arrayCount);
    }

    /**
     * Passing data and minimum of 0 occurrences expects a string with One value and one character count
     *
     * @return void
     */
    public function testWithCorrectCommaSeparatedValuesAndZeroMinOccurrencesExpectsOneResult()
    {
        $commaSeparatedValues = '1, 2, 2, 3, 3, 3';
        $numberOfMinimumOccurrences = 0;
        $stringHelper = new StringHelper();
        $answer = $stringHelper->occurrence(
            $commaSeparatedValues,
            $numberOfMinimumOccurrences
        );

        $this->assertSame(1, strlen($answer));
    }
}
