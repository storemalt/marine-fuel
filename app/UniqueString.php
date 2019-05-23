<?php
declare(strict_types=1);

namespace App;

use App\Helpers\StringHelper;
use App\Interfaces\SolutionInterface;
use Illuminate\Http\Request;

class UniqueString implements SolutionInterface
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Retrieves the unique combination of characters from any given string value
     * @return string
     */
    public function process(): string
    {
        $stringHelper = new StringHelper();
        $uniqueWord = $stringHelper->longestUniqueString($this->request->word);

        return $uniqueWord;
    }
}
