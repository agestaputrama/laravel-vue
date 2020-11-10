<?php
namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PhpParser\Builder\Function_;
use App\Traits\UsesUuid;
use App\Otp_code;
use Carbon\Carbon;

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

        static::created(function ($model){
            $model->generate_otp_code();
        });
    }

    public function generate_otp_code(){
        do{
            $random = mt_rand(100000, 999999);
            $check = Otp_code::where('code', $random)->first();
        }while ($check);

        $now = Carbon::now('Asia/Jakarta');

        //create otp code
        $otp_code = Otp_code::updateOrCreate(
            ['user_id' => $this->id],
            ['code' => $random, 'valid_until' => $now->addMinutes(5)]
        );
    }

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
