<?php

namespace App\Http\Controllers;

use App\Models\SalesData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SalesDatasController extends Controller
{
    //
    public function index(Request $request)
    {
        $salesDatas = $request->user()->salesData()->orderBy('sales_time','desc')->paginate(100);
        $weachts = $request->user()->wechat()->get();
        //dd($weachts);
        return view('sales.index',compact('salesDatas','weachts'));
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
//
//        $messages = [
//            'unique' => $request->sales_time.'日进线数据已经存在',
//        ];
//
//        $validator = Validator::make($request->all(),[
//            'sales_time' => [
//                'required',
//                Rule::unique('sales_datas')->where(function ($query) use ($user){
//                    return $query->where('user_id', $user->id);
//                })
//            ]
//        ],$messages);
//
//        if ($validator->fails()) {
//            return redirect('sales/create')->withErrors($validator)->withInput();
//        }

        $salesData = new SalesData([
            'sales_time'         => $request->sales_time,
            'channel'            => $request->channel,
            'enter_number'       => $request->enter_number,
            'repay_number'       => $request->repay_number,
            'delete_number'      => $request->delete_number,
            'transaction_amount' => $request->transaction_amount,
            'transaction_number' => $request->transaction_number,
            'wechat_id'          => $request->wechat_id,
        ]);

        $salesData->user()->associate($user);
        $salesData->save();
        return redirect()->route('sales.index');
    }

    public function update(Request $request,SalesData $salesData)
    {
        $user = $request->user();
        $salesData->user()->associate($user);
        // 获取今日时间
        // 当前进线操作日志
        $mark = $salesData->mark;
        $mark[] = array_except($salesData->toArray(),['id','user_id','sales_time','mark','created_at','user']);
        $salesData->update([
            'sales_time'         => $request->sales_time,
            'channel'            => $request->channel,
            'enter_number'       => $request->enter_number,
            'repay_number'       => $request->repay_number,
            'delete_number'      => $request->delete_number,
            'transaction_amount' => $request->transaction_amount,
            'transaction_number' => $request->transaction_number,
            'mark'               => $mark,
            'wechat_id'          => $request->wechat_id,
        ]);

        return redirect()->route('sales.index');
    }

    public function show()
    {

    }
}
