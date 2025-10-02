<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManualRequest;
use App\Models\Manual;
use Illuminate\Http\Request;

class ManualController extends Controller
{
    //
    public function index()
    {
        return view('manuals.index');
    }

    public function create()
    {

        return view('manuals.create');
    }

    public function store(StoreManualRequest $request)
    {

        dd($request->all());

    }
}
