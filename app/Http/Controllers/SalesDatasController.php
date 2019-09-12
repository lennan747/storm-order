<?php

namespace App\Http\Controllers;

use App\Models\SalesData;
use Illuminate\Http\Request;

class SalesDatasController extends Controller
{
    //
    public function index(Request $request)
    {
        $salesDatas = $request->user()->salesData()->orderBy('sales_time','desc')->paginate(10);
        return view('sales.index',compact('salesDatas'));
    }

    public function create(SalesData $salesData)
    {
        return view('sales.create_and_edit',compact('salesData'));
    }

    public function edit(SalesData $salesData){
        return view('sales.create_and_edit',compact('salesData'));
    }

    public function store(Request $request){
        $user = $request->user();

        $salesData = new SalesData([
            'sales_time'         => $request->sales_time,
            'channel'            => $request->channel,
            'enter_number'       => $request->enter_number,
            'repay_number'       => $request->repay_number,
            'delete_number'      => $request->delete_number,
            'transaction_amount' =>$request->transaction_amount,
            'transaction_number' => $request->transaction_number
        ]);

        $salesData->user()->associate($user);
        $salesData->save();
        return redirect()->route('sales.index');
    }

    public function update(Request $request,SalesData $salesData)
    {
        $user = $request->user();
        $salesData->user()->associate($user);

        $salesData->update([
            'sales_time'         => $request->sales_time,
            'channel'            => $request->channel,
            'enter_number'       => $request->enter_number,
            'repay_number'      => $request->repay_number,
            'delete_number'      => $request->delete_number,
            'transaction_amount' =>$request->transaction_amount,
            'transaction_number' => $request->transaction_number
        ]);
        return redirect()->route('sales.index');
    }

    public function show()
    {

    }
}
