<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Otp_code extends Model
{
    use UsesUuid;

    protected $guarded = [];

    // protected $fillable = [
    //    'user_id', 'code', 'valid_until',
    // ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    
}
