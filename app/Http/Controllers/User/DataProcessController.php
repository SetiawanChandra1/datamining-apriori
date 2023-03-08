<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DataProcessModel;
use App\Models\TransactionsModel;
use Illuminate\Http\Request;
### Additional ###


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
        //save data to database
        $data = new DataProcessModel();
        $data->username = auth()->user()->name;
        $data->start_date = $request->input('start_date');
        $data->end_date = $request->input('end_date');
        $data->min_support = $request->input('minimum_support');
        $data->min_confidence = $request->input('minimum_confidence');
        $data->save();

        /// Get input from request
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $minimum_support = $request->input('minimum_support');
        $minimum_confidence = $request->input('minimum_confidence');

        // Get unique variants
        $getVariant = \DB::select("
            SELECT DISTINCT SUBSTRING_INDEX(variant, ',', 1) AS variant 
            FROM transactions_models 
            UNION 
            SELECT DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(variant, ',', 2), ',', -1) AS variant 
            FROM transactions_models
        ");

        // Get transactions within date range
        $transactionModels = \App\Models\TransactionsModel::whereBetween('date', [$start_date, $end_date])->get();

        // Get count transactions within date range
        $totalTransactions = $transactionModels->count();

        // Get frequency of each variant
        $variantFrequency = [];
        foreach ($getVariant as $variant) {
            $variantFrequency[$variant->variant] = 0;
            foreach ($transactionModels as $transaction) {
                if (strpos($transaction->variant, $variant->variant) !== false) {
                    $variantFrequency[$variant->variant]++;
                }
            }
        }

        // Calculate minimum support for each variant
        $minimumSupport = [];
        foreach ($variantFrequency as $variant => $frequency) {
            $minimumSupport[$variant] = round($frequency / $totalTransactions * 100, 2);
        }

        // Filter items that pass and fail the minimum support
        $passMinimumSupport = array_filter($minimumSupport, function($support) use ($minimum_support) {
            return $support >= $minimum_support;
        });

        $failMinimumSupport = array_filter($minimumSupport, function($support) use ($minimum_support) {
            return $support < $minimum_support;
        });

        return inertia('User/Dashboard/DataProcess/Index', [
            'variantFrequency'   => $variantFrequency,
            'passMinimumSupport' => $passMinimumSupport,
            'failMinimumSupport' => $failMinimumSupport,
            'minimum_support'    => $minimum_support,
            'minimum_confidence' => $minimum_confidence,
            'totalTransactions'  => $totalTransactions,
        ]);  
    }
        // return redirect(route('user.dashboard.dataprocess.index'))->with([
        //     'message' => "Data Processed successfully",
        //     'type' => 'success'
        // ]);

    // Get all possible combinations of variants
    // $variantCombinations = array();
    // foreach ($getVariant as $variant) {
    //     foreach ($getVariant as $variant2) {
    //         if ($variant->variant != $variant2->variant) {
    //             $variantCombinations[] = $variant->variant . ',' . $variant2->variant;
    //         }
    //     }
    // }
    // dd($variantCombinations);
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
