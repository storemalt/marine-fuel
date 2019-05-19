<?php
declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Http\Request;

interface SolutionInterface
{
    public function process(Request $request);
}
