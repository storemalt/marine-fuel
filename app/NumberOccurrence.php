<?php
declare(strict_types=1);

namespace App;

use App\Helpers\StringHelper;
use App\Interfaces\SolutionInterface;
use Illuminate\Http\Request;

class NumberOccurrence implements SolutionInterface
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handles the number occurrence process
     * @return string comma separated values of elements with re-occurrence
     */
    public function process(): string
    {
        $stringHelper = new StringHelper();
        $answer = $stringHelper->occurrence(
            $this->request->array_values,
            intval($this->request->number_occurrences)
        );

        return $answer;
    }
}
