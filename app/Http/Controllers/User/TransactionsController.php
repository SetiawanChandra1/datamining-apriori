<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TransactionsModel;
use Illuminate\Http\Request;
### Additional ###
use App\Imports\TransactionsImport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $importedData = TransactionsModel::all();
        return inertia('User/Dashboard/Transactions/Index', [
            'importedData' => $importedData
        ]);
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
    public function edit($id)
    {
        $TransactionsModel = TransactionsModel::find($id);
        return inertia('User/Dashboard/Transactions/EditTransactions', [
            'TransactionsModel' => $TransactionsModel
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionsModel  $transactionsModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code_transactions'     => 'required',
            'date'     => 'required',
            'variant'   => 'required'
        ]);

        $transaction = TransactionsModel::findOrFail($id);

        $transaction->code_transactions = $request->input('code_transactions');
        $transaction->date = $request->input('date');
        $transaction->variant = $request->input('variant');
    
        $transaction->save();
    
        return redirect(route('user.dashboard.transactions.index'))->with([
            'message' => "Data updated successfully",
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionsModel  $transactionsModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = TransactionsModel::findOrFail($id);
        $transaction->delete();

        return redirect(route('user.dashboard.transactions.index'))->with([
            'message' => "Data deleted successfully",
            'type' => 'success'
        ]);
    }


    public function import(Request $request)
    {
        $this->validate($request, [
            'dataexcel' => 'required|mimes:csv,xls,xlsx'
        ]);

        $filePath = $request->file('dataexcel')->getRealPath();

        $transactions = [];
        $variants = [];
        $dates = [];

        $reader = Excel::toArray([], request()->file('dataexcel'));
        foreach ($reader[0] as $key => $row) {
            if ($key > 0) {
                $code = substr($row[0], -9);
                $date = $row[1];
                $variant = $row[2];

                // Save Code Transactions, Date, and Variant on array
                $transactions[] = $code;
                $dates[] = $date;
                $variants[$code][] = $variant;
            }
        }

        $results = [];

        foreach (array_unique($transactions) as $key => $code) {
            $variants_text = implode(',', $variants[$code]);
        
            // Find the first date for this code
            $date = null;
            foreach ($reader[0] as $row) {
                if (substr($row[0], -9) === $code) {
                    $date = $row[1];
                    break;
                }
            }
        
            // Create a new TransactionsModel object and save it to the database
            $transaction = new TransactionsModel();
            $transaction->code_transactions = $code;
            $transaction->date = $date;
            $transaction->variant = $variants_text;
            $transaction->save();
        }
        

        return back()->with([
            'message' => "Succesfully Imported Data and Saved to Database",
            'type' => "success"
        ]);
    }

}
