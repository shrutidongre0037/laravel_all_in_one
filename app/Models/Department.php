<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\SoftDeletes;



class Department extends Model
{
    use HasFactory,ModelEventLogger,SoftDeletes;
    protected $connection = 'tenant';
    protected $fillable=['name'];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];

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
