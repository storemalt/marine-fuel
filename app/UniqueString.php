<?php
declare(strict_types=1);

namespace App;

use App\Helpers\StringHelper;
use App\Interfaces\SolutionInterface;
use Illuminate\Http\Request;

class UniqueString implements SolutionInterface
{
    public function process(Request $request): string
    {
        $uniqueWord = StringHelper::longestUniqueString($request->word);

        return $uniqueWord;
    }
}
