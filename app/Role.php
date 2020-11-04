<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Role extends Model
{
    use UsesUuid;

    protected $guarded = [];
    
    // protected $fillable = [
    //     'role',
    // ];

    public function user(){
	    return $this->hasMany('App\User');
	}
}
