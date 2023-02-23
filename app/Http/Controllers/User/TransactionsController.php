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

        Excel::import(new TransactionsImport, request()->file('dataexcel')->getRealPath());

        return back()->with([
			'message' => "Succesfully Imported Data",
			'type' => "success"
		]);
    }
}
