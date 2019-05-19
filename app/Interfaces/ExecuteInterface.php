<?php
declare(strict_types=1);

namespace App\Interfaces;
use Illuminate\Http\Request;

interface ExecuteInterface
{
    public function __construct(SolutionInterface $solution, Request $request);
    public function execute();
}
