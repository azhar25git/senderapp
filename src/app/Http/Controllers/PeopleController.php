<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->validate($request, [
        //     'year' => 'integer',
        //     'month' => 'integer',
        //     'filter' => 'sometimes|integer',
        //     'page' => 'sometimes|integer',
        // ]);

        // $skip = 0;
        // $limit = 0;

        // if ($request->page > 1) {
        //     $limit = (config('sender.limit') * ($request->page - 1));
        // }
        // $limit =  config('sender.limit') + $limit;
        // config('sender.cache_key') = 'people-filter';
        // if(request('filter') == 1){
        //     if(!isset($people)){
        //         if(Cache::has(config('sender.cache_key'))) {
        //             $people = Cache::get(config('sender.cache_key'));
        //         } else {
        //             $people = People::all();
        //             Cache::put(config('sender.cache_key'), $people);
        //         }
        //     } else {
        //         $people = Cache::get(config('sender.cache_key'));
        //     }
        // }
        // if(request('filter') == 1){
        //     if(request('year') > 0) {
        //         Session::put('year', request('year'));
        //     } else {
        //         Session::forget('year');
        //     }

        //     if(request('month') > 0) {
        //         Session::put('month', request('month'));
        //     } else {
        //         Session::forget('month');
        //     }

        //     $people = People::query();
        //     $people->when(Session::has('year'), function($q) {
        //         return $q->whereYear('dob', Session::get('year'));
        //     });
    
        //     $people->when(Session::has('month'), function($q) {
        //         return $q->whereMonth('dob', Session::get('month'));
        //     });
        //     $people = $people->get();
        //     Cache::put(config('sender.cache_key'), $people, 60);
        //     $people = $this->paginate($people, config('sender.limit'));
        //     return redirect()->view("people.index")->with([
        //         "people" => $people
        //     ]);
        //     // View::make("people.index")
        //     //     ->with([
        //     //         "people" => $people
        //     //         ])
        //     //     ->render();
        // }

        // if(count($people)){
        //     $people = $people
        //     ->skip($skip)
        //     ->take($limit);
        // }

        // $people = $this->paginate($people, config('sender.limit'));
        // $output = View::make("people.index")
        //     ->with([
        //         "people" => $people
        //         ])
        //     ->render();

        // echo $output;
    }

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
        $skip = 0;
        $limit = 0;

        if ($req->page > 1) {
            $limit = (config('sender.limit') * ($req->page - 1));
        }
        $limit =  config('sender.limit') + $limit;

        $people = $this ->paginate($people, config('sender.limit'))
                        ->withPath(route('people'))
                        ->withQueryString();

        return view('people.index', [
            'people' => $people
        ]);
    }


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


    private function getFilteredData(Request $req)
    {
        if(session()->get('year') == 0 && session()->get('month')) {
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


    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
