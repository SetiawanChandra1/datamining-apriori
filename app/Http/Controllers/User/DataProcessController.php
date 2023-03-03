<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DataProcessModel;
use Illuminate\Http\Request;

class DataProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('User/Dashboard/DataProcess/Index');
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
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'minimum_support' => 'required|numeric|min:0',
            'minimum_confidence' => 'required|numeric|min:0',
        ]);

        $data = new DataProcessModel();
        $data->username = auth()->user()->name;
        $data->start_date = $request->input('start_date');
        $data->end_date = $request->input('end_date');
        $data->min_support = $request->input('minimum_support');
        $data->min_confidence = $request->input('minimum_confidence');
        $data->save();

        return redirect(route('user.dashboard.dataprocess.index'))->with([
            'message' => "Data Inserted successfully",
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataProcessModel  $dataProcessModel
     * @return \Illuminate\Http\Response
     */
    public function show(DataProcessModel $dataProcessModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataProcessModel  $dataProcessModel
     * @return \Illuminate\Http\Response
     */
    public function edit(DataProcessModel $dataProcessModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataProcessModel  $dataProcessModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataProcessModel $dataProcessModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataProcessModel  $dataProcessModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataProcessModel $dataProcessModel)
    {
        //
    }
}
