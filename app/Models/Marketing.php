<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class Marketing extends Model
{
    
    use HasFactory, Notifiable, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'email', 'phone', 'address', 'image'];
public $incrementing = false;
    protected $keyType = 'string';


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); 
        });
    }

    public function getRouteKeyName()
    {
        return 'id'; // This is default, but explicitly setting it is good practice for UUIDs
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

     public function setEmailAttribute($value)
    {
        $this->attributes['email']=strtolower($value);
    } 
public function getImageAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return 'marketings/default.png';
    }
}
