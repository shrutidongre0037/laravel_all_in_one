<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Department extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $fillable=['name'];
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

    public function developments()
    {
        return $this->hasMany(Development::class);
    }

}
