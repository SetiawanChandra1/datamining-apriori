<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TransactionsModel;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('User/Dashboard/Transactions/Index');
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
     * @param  \App\Models\TransactionsModel  $transactionsModel
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionsModel $transactionsModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionsModel  $transactionsModel
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionsModel $transactionsModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionsModel  $transactionsModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionsModel $transactionsModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionsModel  $transactionsModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionsModel $transactionsModel)
    {
        //
    }
}
