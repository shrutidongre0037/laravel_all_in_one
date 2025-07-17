<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class Development extends Model
{
    
    use HasFactory, Notifiable, SoftDeletes;
    protected $connection = 'tenant';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'email', 'phone', 'address', 'image','department_id'];
    public $incrementing = false;
    protected $keyType = 'string';


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); 
        });

        static::saved(function ($model) {
            Log::warning('Development saved: ' . $model->name);
        });

        static::deleting(function ($model) {
            Log::warning('Development deleting: ' . $model->id);
        });
        static::updated(function ($model) {
            Log::info('Development updated: ' . $model->name);
        });

        static::creating(function ($model) {
        Log::info('Development creating: ' . $model->name);
        });

        static::created(function ($model) {
        Log::info('Development created: ' . $model->name);
        });
    
        static::updating(function ($model) {
            Log::info('Development updating: ' . $model->name);
        });
    
        static::deleted(function ($model) {
            Log::warning('Development deleted: ' . $model->id);
        });

        static::saving(function ($model) {
            Log::warning('Development saving: ' . $model->name);
        });
    }

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
