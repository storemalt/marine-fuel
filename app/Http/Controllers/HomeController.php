<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\NumberOccurrence;
use App\Solution;
use App\UniqueString;
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

        $numberOccurrence = new NumberOccurrence($request);
        $solution = new Solution($numberOccurrence);
        $answer = $solution->execute();

        $requiredResults = ($request->number_occurrences < 1) ? 1 : $request->number_occurrences;
        $message = 'The top ' . $requiredResults . ' occurrence(s): ' . $answer;

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
    public function uniqueString(): View
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

        $uniqueString = new UniqueString($request);
        $solution = new Solution($uniqueString);
        $answer = $solution->execute();

        $message = 'The longest unique string is ' . $answer;

        return redirect()->route('home.unique.string')->with('success', $message);
    }

    /**
     * Generates a map that pinpoints location of user who viewed the page
     *
     * @return View
     */
    public function pinPointMapping(): View
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
