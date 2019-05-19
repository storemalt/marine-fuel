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

    public function process(): string
    {
        $uniqueWord = StringHelper::longestUniqueString($this->request->word);

        return $uniqueWord;
    }
}
