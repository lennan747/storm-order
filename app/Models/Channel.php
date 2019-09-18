<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    //
    protected $fillable = [
        'code',
        'name',
    ];


    public function channela_ssgin()
    {
        return $this->hasMany(ChannelAssgin::class);
    }
}
