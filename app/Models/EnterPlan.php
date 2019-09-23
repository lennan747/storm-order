<?php

namespace App\Models;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EnterPlan extends Model
{
    //
//    protected $fillable = [
//        'enter_time',
//        'a1',
//        'a2',
//        'a3',
//        'a4',
//        'a5',
//        'a6',
//        'a7',
//        'a8',
//        'a9',
//        'a10',
//        'a11',
//        'a12',
//        'a13',
//        'a14',
//        'a15',
//        'a16',
//        'a17',
//        'a18',
//        'a19',
//        'a20',
//        'a21',
//        'a22',
//        'a23',
//        'a24',
//        'a25',
//        'a27',
//        'a28',
//        'a29',
//        'a30'
//    ];
//
//    protected $casts = [
//        'enter_time'  => 'date',
//    ];

    public function paginate()
    {
        dd(Request::toArray());
        $perPage = Request::get('per_page', 10);

        $page = Request::get('page', 1);

        $start = ($page-1)*$perPage;

        $wechats = Wechat::query()->orderBy('code','asc')->get();

        // 获取
        $chnnel_assgins = ChannelAssgin::query()->orderBy('datetime', 'desc')->get();
        $res = [];
        $i = 0;
        $tag = [];
        foreach ($chnnel_assgins as $key => $v) {
            $datetime = $v['datetime']->toDateString();
            if (empty($tag) || !isset($tag[$datetime])) {
                $res[$i]['datetime'] = $datetime;
                $res[$i]['info'] = $v;
                $tag[$datetime] = $i;
                $i = $i + 1;
            }else{
                $temp = $res[$tag[$datetime]]['info']['wechat'];
                $temp = array_values(array_unique(array_merge($temp,$v['wechat'])));
                $res[$tag[$datetime]]['info']['wechat'] = $temp;
            }
        }

        foreach ($res as $k => $v) {
            foreach ($wechats as $wechat) {
                $wechat['code'] = (string)$wechat['code'];
                if (in_array($wechat['id'], $res[$k]['info']['wechat']) && $res[$k]['info']['mark']) {
                    $res[$k][$wechat['code']] = $res[$k]['info']['mark'];
                }else{
                    $res[$k][$wechat['code']] = "";
                }
            }
            unset($res[$k]['info']);
        }
        //dd($res);
        $movies = static::hydrate($res);

        $paginator = new LengthAwarePaginator($movies, 12, $perPage);

        $paginator->setPath(url()->current());

        return $paginator;
    }

    public static function with($relations)
    {
        return new static;
    }

}
