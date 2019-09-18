<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    //
    const SHIP_STATUS_PENDING = 'pending';
    const SHIP_STATUS_DELIVERED = 'delivered';
    const SHIP_STATUS_RECEIVED = 'received';

    public static $shipStatusMap = [
        self::SHIP_STATUS_PENDING       => '未发货',
        self::SHIP_STATUS_DELIVERED     => '已发货',
        self::SHIP_STATUS_RECEIVED      => '已收货',
    ];

    //
    protected $fillable = [
        'no',
        'address',
        'fans_name',
        'datetime',
        'payment_method',
        'prepayments',
        'total_amount',
        'remark',
        'closed',
        'reviewed',
        'ship_status',
        'ship_data',
        'phone_number',
        'quantity',
        'channel',
        'taste',
        'transaction_datetime',
        'age',
        'wechat_id'
    ];

    // 这是一个属性转换器
    protected $casts = [
        'closed'    => 'boolean',
        'reviewed'  => 'boolean',
        'address'   => 'json',
        'ship_data' => 'json',
        'datetime'  => 'date',
        'prepayments' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'quantity' => 'integer',
        'transaction_datetime' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(Payment::class,'payment_method','id');
    }

    public function wechat(){
        return $this->belongsTo(Wechat::class);
    }

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 no 字段为空
            if (!$model->no) {
                // 调用 findAvailableNo 生成订单流水号
                $model->no = static::findAvailableNo();
                // 如果生成失败，则终止创建订单
                if (!$model->no) {
                    return false;
                }
            }
        });
    }

    public static function findAvailableNo()
    {
        // 订单流水号前缀
        $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
            $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            // 判断是否已经存在
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
        }
        Log::warning('find order no failed');

        return false;
    }

    public function scopeWithOrder($query, $order)
    {
        switch($order)
        {
            case 'enter':
                $query->datetime();
                break;
            case 'amount':
                $query->amount();
                break;
            default:
                $query->recent();
                break;
        }
    }
    public function scopeAmount($query)
    {
        return $query->orderBy('total_amount', 'desc');
    }

    public function scopeDatetime($query)
    {
        return $query->orderBy('datetime', 'asc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

//    public function getShipDataAttribute($ship_data){
//        return array_values(json_decode($ship_data,true)?:[]);
//    }
//
//    public function setShipDataAttribute($ship_data)
//    {
//        $this->attributes['ship_data'] = json_encode(array_values($ship_data));
//    }
}
