<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Traits\ModelEventLogger;


class Development extends Model
{
    
    use HasFactory, Notifiable, SoftDeletes , ModelEventLogger;
    protected $connection = 'tenant';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'email', 'phone', 'address', 'image','department_id'];
    public $incrementing = false;
    protected $keyType = 'string';


    
    public function getRouteKeyName()
    {
        return 'id'; // This is default, but explicitly setting it is good practice for UUIDs
    }

    //Accessor : Captalize name when it get from DB
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    //Mutator : save email in lowerCase before saving to database
    public function setEmailAttribute($value)
    {
        $this->attributes['email']=strtolower($value);
    } 

    //Accessor : to show default image when it is left null
    public function getImageAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return 'developments/default.png';
    }

    //one to many relationship
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    //many to many relationship
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

}
