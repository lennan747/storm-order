<?php

namespace App\Http\Requests;

class OrderRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
                {
                    return [
                        'fans_name'      => 'required|between:2,25',
                        'datetime'       => 'required|date_format:Y-m-d',
                        'prepayments'    => 'required|numeric',
                        'payment_method' => 'required',
                        'total_amount'   => 'required|numeric',
                        'province'       => 'required|max:10',
                        'city'           => 'required|max:10',
                        'district'       => 'nullable|max:50',
                        'address'        => 'required|max:200',
                        'phone_number'   => 'required|regex:/^1[3456789][0-9]{9}$/',
                        'remark'         => 'nullable|max:100',
                        'quantity'       => 'nullable|numeric',
                        'express'        => 'required',
                        'wechat_id'      => 'required|numeric'
                    ];
                }
            // UPDATE
            case 'PUT':
                {
                    return [
                        'fans_name'      => 'required|between:2,25',
                        'datetime'       => 'required|date_format:Y-m-d',
                        'prepayments'    => 'required|numeric',
                        'payment_method' => 'required',
                        'total_amount'   => 'required|numeric',
                        'province'       => 'required|max:10',
                        'city'           => 'required|max:10',
                        'district'       => 'nullable|max:50',
                        'address'        => 'required|max:200',
                        'phone_number'   => 'required|regex:/^1[3456789][0-9]{9}$/',
                        'remark'         => 'nullable|max:100',
                        'quantity'       => 'nullable|numeric',
                        'express'        => 'required',
                        'wechat_id'      => 'required|numeric'
                    ];
                }
            case 'PATCH':
            case 'GET':
                {
                    return [
                        'fans_name'           => 'nullable',
                        'ship_status'         => 'nullable',
                        'closed'              => 'nullable|numeric',
                        'create_at'           => 'nullable|date_format:Y-m-d'
                    ];
                }
            case 'DELETE':
            default:
                {
                    return [];
                };
        }
    }

    public function attributes()
    {
        return [
            'fans_name'               => '客户姓名或微信号',
            'datetime'                => '进线时间',
            'prepayments'             => '预付款',
            'total_amount'            => '成交价',
            'payment_method'          => '付款方式',
            'province'                => '省份',
            'city'                    => '城市',
            'district'                => '地区',
            'address'                 => '收货地址',
            'phone_number.required'   => '收货人电话',
            'phone_number.regex'      => '收货人电话格式不对',
            'remark'                  => '备注',
            'express'                 => '快递方式'
        ];
    }
}
