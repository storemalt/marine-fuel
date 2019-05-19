<?php
declare(strict_types=1);

namespace App;

use App\Interfaces\ExecuteInterface;
use App\Interfaces\SolutionInterface;
use Illuminate\Http\Request;

class Solution implements ExecuteInterface
{
    private $request;
    private $solution;

    public function __construct(SolutionInterface $solution = null, Request $request = null)
    {
        $this->request = $request;
        $this->solution = $solution;
    }

    public function execute()
    {
        return $this->solution->process($this->request);
    }

}
