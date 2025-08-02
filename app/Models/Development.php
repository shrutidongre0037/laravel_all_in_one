<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Traits\ModelEventLogger;
use App\Traits\RelationshipTrait;
use App\Models\Department;

class Development extends Model
{
    use HasFactory, Notifiable, SoftDeletes, ModelEventLogger, RelationshipTrait;
    protected $connection = 'tenant';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'email', 'phone', 'address', 'image'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::bootRelationshipTrait(); // 🔥 This is critical
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
        $this->attributes['email'] = strtolower($value);
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
    //many to many relationship
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_development')->withPivot('id')
            ->withTimestamps();
    }
    public function profile()
    {
        return $this->hasOneThrough(
            \App\Models\Profile::class,
            'development_id', // Foreign key on ProfileLink
            'id',             // Foreign key on Profile
            'id',             // Local key on Development
            'profile_id'      // Local key on ProfileLink
        );
    }
}
