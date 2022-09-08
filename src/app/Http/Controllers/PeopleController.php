<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PeopleController extends Controller
{
    /**
     * Make a list of people which are filterable
     *
     * @param Request $req
     * @return void
     */
    public function listData(Request $req)
    {
        // validation
        $this->validate($req, [
            'year' => 'integer',
            'month' => 'integer',
            'page' => 'sometimes|integer',
        ]);
        // Sessionize
        if($req->year != session()->get('year')){
            Session::put('year', $req->year);
            Cache::forget(config('sender.cache_key'));
        }

        if($req->month != session()->get('month')){
            Session::put('month', $req->month);
            Cache::forget(config('sender.cache_key'));
        }
        
        // pull data
        $people = $this->pullDataCache($req);
        
        // pagination
        // $limit = 0;

        // if ($req->page > 1) {
        //     $limit = (config('sender.limit') * ($req->page - 1));
        // }
        // $limit =  config('sender.limit') + $limit;

        $people = $this ->paginate($people, config('sender.limit'))
                        ->withPath(route('people'))
                        ->withQueryString();

        return view('people.index', [
            'people' => $people
        ]);
    }

    /**
     * Get cached data or prepare cache
     *
     * @param Request $req
     * @return void
     */
    private function pullDataCache(Request $req)
    {
        if(Cache::has(config('sender.cache_key'))) {
            $people = Cache::get(config('sender.cache_key'));
        } else {
            $people = $this->getFilteredData($req);
            Cache::put(config('sender.cache_key'), $people, config('sender.cache_timeout'));
        }

        return $people;
    }

    /**
     * Fetch filtered data from DB
     *
     * @param Request $req
     * @return void
     */
    private function getFilteredData(Request $req)
    {
        if(session()->get('year') == 0 && session()->get('month') == 0) {
            $people = People::get();
        } else {
            $people = People::query();
            $people->when(session()->get('year') != 0, function($q) {
                return $q->whereYear('dob', session()->get('year'));
            });
    
            $people->when(session()->get('month') != 0, function($q) {
                return $q->whereMonth('dob', session()->get('month'));
            });

            $people = $people->get();
        }

        return $people;
    }

    /**
     * Create custom data pagination for Laravel collection object
     *
     * @param [type] $items
     * @param integer $perPage
     * @param [type] $page
     * @param array $options
     * @return void
     */
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
