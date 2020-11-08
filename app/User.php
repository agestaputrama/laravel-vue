<?php
namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PhpParser\Builder\Function_;
use App\Traits\UsesUuid;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, UsesUuid;

    protected function get_admin_id(){
        $role = \App\Role::where('role', 'admin')->first();
        return $role->id;
    }
    protected function get_user_id(){
        $role = \App\Role::where('role', 'user')->first();
        return $role->id;
    }

    public static function boot(){
        parent::boot();
        static::creating(function ($model){
            $model->role_id = $model->get_user_id();
        });
    }

   

//start setting uuid
    // protected static function boot() {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         if ( ! $model->getKey()) {
    //             $model->{$model->getKeyName()} = (string) Str::uuid();
    //         }
    //     });
    // }

    // public function getIncrementing()
    // {
    //     return false;
    // }

    // public function getKeyType()
    // {
    //     return 'string';
    // }
//end membuat uuid

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role_id', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function Otp_code(){
        return $this->hasOne('App\Otp_code');
    }

    public function isAdmin(){
        if($this->role_id == '39d2033b-0fac-477c-98cd-a8aaed75cfb8'){
            return true;
        }
        return false;
    }

    public function isUser(){
        if($this->role_id == 'fb26e33b-8a1f-4ead-8327-918ccd7d1b96'){
            return true;
        }
        return false;
    }

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
