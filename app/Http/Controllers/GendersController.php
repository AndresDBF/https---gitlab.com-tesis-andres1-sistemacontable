<?php

namespace App\Http\Controllers;

use App\Gender;
use Illuminate\Http\Request;

class GendersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gender::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\genders  $genders
     * @return \Illuminate\Http\Response
     */
    public function show(genders $genders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\genders  $genders
     * @return \Illuminate\Http\Response
     */
    public function edit(genders $genders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\genders  $genders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, genders $genders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\genders  $genders
     * @return \Illuminate\Http\Response
     */
    public function destroy(genders $genders)
    {
        //
    }
}
