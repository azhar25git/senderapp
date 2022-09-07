<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use Illuminate\Support\Facades\View;

class FilterController extends Controller
{
    public function filter(Request $request)
    {
        $this->validate($request, [
            'year' => 'sometimes|integer',
            'month' => 'sometimes|integer'
        ]);

        $people = People::query();

        $people->when(request('year') != 0, function($q) {
            return $q->whereYear('dob', request('year'));
        });
        
        $people->when(request('month') != 0, function($q) {
            return $q->whereMonth('dob', request('month'));
        });

        $people = $people->simplePaginate(config('sender.limit'));
        $output = View::make("people.index")
            ->with("people", $people)
            ->render();

        echo $output;
    }
}
