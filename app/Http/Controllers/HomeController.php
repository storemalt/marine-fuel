<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\NumberOccurrence;
use App\Solution;
use App\UniqueString;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        $locations = $this->getCache();
        if (empty($locations)) {
            $locations[] = [
                "lat" => 3.108864,
                "lng" => 101.58735360000001,
                "label" =>"Ship 0"
            ];
            $locations = json_encode($locations);
        }

        return view('pinpoint-map', [
            'action' => action('HomeController@storeLocation'),
            'locations' => $locations,
        ]);
    }

    /**
     * Stores the location of the user who viewed the pinpoint location page
     * caching would require a cron job on the server or a data store engine like redis or memcached
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeLocation(Request $request): RedirectResponse
    {
        $request->validate([
            'current_location' => 'required',
            'location_name' => 'required',
            'duration' => 'required|integer',
        ]);

        if ($request->has('_token')) {
            $data = json_decode($request->current_location, true);
            $data['label'] = $request->location_name;
            $expirationHours = intval($request->duration);

            // cache deletion would require a cron job on the server or using a (nosql) data store engine
            // temporarily saved in a file storage
            if (Cache::has('locations')) {
                $locations = $this->getCache();
                $locations[] = $data;
                $this->putCache(json_encode($locations), now()->addHours($expirationHours));

            } else {
                $locations[] = $data;
                $this->putCache(json_encode($locations), now()->addHours($expirationHours));
            }
        }

        return redirect()->route('home.pinpoint.map')->with('success', 'Successfully saved the location.');
    }

    public function getCache(string $key = 'locations')
    {
        return Cache::get($key);
    }

    public function putCache(string $locations, Carbon $expirationHours, string $key = 'locations')
    {
        return Cache::put($key, $locations, $expirationHours);
    }
}
