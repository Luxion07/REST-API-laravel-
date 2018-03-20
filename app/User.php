<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\ImageableTrait;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable,ImageableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image_source', 'register_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at',
    ];


	public function likes()
	{
		return $this->morphMany('App\Like', 'likeable');
	}
//    public function getRegisterDateAttribute()
//    {
//       return $this->attributes['register_date'] == 'yes';
//    }
    protected $appends = ['register_date'];

    public function getRegisterDateAttribute($value)
    {
        return $this->created_at->format('d M Y');
    }

}
