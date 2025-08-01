<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RelationshipTrait;


class Department extends Model
{
    use HasFactory,ModelEventLogger,SoftDeletes,RelationshipTrait;
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
    return $this->belongsToMany(Development::class, 'department_development')->withPivot('id')
        ->withTimestamps();
}
    

}
