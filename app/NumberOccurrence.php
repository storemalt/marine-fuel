<?php


namespace App;


use App\Helpers\NumberHelper;
use App\Interfaces\SolutionInterface;
use Illuminate\Http\Request;

class NumberOccurrence implements SolutionInterface
{
    public function process(Request $request): string
    {
        $numberOccurrences = $request->number_occurrences;
        $arrayValues = $request->array_values;
        $answer = NumberHelper::numberOccurrence(
            $arrayValues,
            $numberOccurrences
        );

        return $answer;
    }
}
