<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * You have an array of n characters or integers. Write a function to return the k most frequently
     * occurring elements. For your answer, we will need the function codes, output based on the
     * following input and a short description of what you are trying to achieve.
     *
     * @return View
     */
    public function index()
    {
        $topElements = [];

        return view('home', [
            'topElements' => implode(',',$topElements),
            'action'=>action('HomeController@occurrence')
        ]);
    }

    /**
     * Checks for number of occurrence in a given array of values
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function occurrence(Request $request)
    {
        $request->validate([
            'array_values' => 'required',
            'number_occurrences' => 'required|integer',
        ]);

        $numberOccurrences = $request->number_occurrences;
        if ($numberOccurrences < 1) {
            $numberOccurrences = 0;
        }

        $strippedCommas = trim($request->array_values, ',');
        $arrayConverted = explode(',',$strippedCommas);
        $occurrences = array_count_values($arrayConverted);
        arsort($occurrences, SORT_NUMERIC);
        $topOccurrences = array_slice($occurrences, 0, $numberOccurrences, true);
        $keys = array_keys($topOccurrences);
        $answer = implode(', ', $keys);
        $message = 'The top ' .  $numberOccurrences . ' occurrence(s): ' . $answer;
        return redirect()->route('home')->with('success', $message);
    }
}
