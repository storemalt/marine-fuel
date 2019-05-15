<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelper;
use Illuminate\Http\RedirectResponse;
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
    public function index(): View
    {
        return view('home', [
            'action' => action('HomeController@occurrence')
        ]);
    }

    /**
     * Checks for number of occurrence in a given array of values
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function occurrence(Request $request): RedirectResponse
    {
        $request->validate([
            'array_values' => 'required',
            'number_occurrences' => 'required|integer',
        ]);

        $numberOccurrences = $request->number_occurrences;
        if ($numberOccurrences < 1) {
            $numberOccurrences = 0;
        }

        $answer = StringHelper::numberOccurrence(
            $request->array_values,
            $request->number_occurrences
        );
        $message = 'The top ' . $numberOccurrences . ' occurrence(s): ' . $answer;

        return redirect()->route('home.occurrence')->with('success', $message);
    }

    /**
     * You have a string of characters. Write a function to find and return the length of the substring
     * which is the longest with unique. I.e. non-repeating characters. For your answer, we will need
     * the function codes, output based on the following input and a short description of what you are
     * trying to achieve.
     *
     * @return View
     */
    public function uniqueString()
    {
        return view('unique', [
            'action' => action('HomeController@unique')
        ]);
    }

    /**
     * Retrieves the unique string from a given string
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function unique(Request $request): RedirectResponse
    {
        $request->validate([
            'word' => 'required',
        ]);

        $uniqueWord = StringHelper::longestUniqueString($request->word);
        $message = 'The longest unique string is ' . $uniqueWord;

        return redirect()->route('home.unique.string')->with('success', $message);
    }

    /**
     * Generates a map that pinpoints location of user who viewed the page
     *
     * @return View
     */
    public function pinPointMapping()
    {
        return view('pinpoint-map', [
            'action' => action('HomeController@storeLocation')
        ]);
    }

    /**
     * Stores the location of the user who viewed the pinpoint location page
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeLocation(Request $request): RedirectResponse
    {
        $request->validate([
            'location' => 'required',
        ]);

        //store in json file location

        return redirect()->route('home.unique.string')->with('success', 'Successfully saved the location.');
    }
}
