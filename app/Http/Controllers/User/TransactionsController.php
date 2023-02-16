<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Session;

use App\Imports\TransactionsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\TransactionsModel;

class TransactionsController extends Controller
{
    public function index(){
        return inertia('User/Dashboard/Transactions/Index');
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
