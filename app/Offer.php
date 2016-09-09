<?php

namespace App;

use Firebase\JWT\JWT;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Moloquent\Eloquent\Builder;
use Moloquent\Eloquent\Model as Model;

/**
 * @property string name
 */
class Offer extends Model
{
    // --------------------------------------------------------------
    // Properties
    // --------------------------------------------------------------
    protected $guarded = [];
    protected $appends = ['image'];
    protected $visible=['_id',"name","location",'topics'];
    protected $with=['topics'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sorted', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    // --------------------------------------------------------------
    // Relations
    // --------------------------------------------------------------

    public function topics() {
        return $this->hasMany('App\Topic');
    }

    // --------------------------------------------------------------
    // Attributes
    // --------------------------------------------------------------

    public function getImageAttribute()
    {
        $path='storage/shop/' . $this->id. '.jpg';
        if(!file_exists($path))
            return url('/img/default.png');
        return url($path).'?'.filemtime($path);
    }

}
