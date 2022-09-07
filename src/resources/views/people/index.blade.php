@extends('layouts.default')

@section('content')
<h1>Top Secret CIA database</h1>
<form action="{{ route('people') }}" class="d-flex justify-content-start align-items-end my-3 p-0">
    @csrf
    <div class="d-flex flex-column col-3 me-4">
        <label for="">Birth year</label>
        <input class="form-control" type="number" name="year" value="{{ session()->get('year') != 0 ? session()->get('year') : '' }}" placeholder="Year" step="1" max="2022">
    </div>
    <div class="d-flex flex-column col-3 me-4">
        <label for="">Birth month</label>
        <input class="form-control" type="number" name="month" value="{{ session()->get('month') != 0 ? session()->get('month') : '' }}" placeholder="Month" step="1" max="12">
    </div>
    <button type="submit" id="filter-btn" class="btn btn-warning">Filter</button>
</form>
<div id="table-container" class="mx-0 px-0">
    <x-tableview :people="$people"/>
</div>
@stop