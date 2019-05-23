<?php
declare(strict_types=1);

namespace App;

use App\Interfaces\ExecuteInterface;
use App\Interfaces\SolutionInterface;

class Solution implements ExecuteInterface
{
    private $solution;

    public function __construct(SolutionInterface $solution = null)
    {
        $this->solution = $solution;
    }

    public function execute()
    {
        return $this->solution->process();
    }

}
