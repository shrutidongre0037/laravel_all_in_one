<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RelationshipTrait;

class DevelopmentProfile extends Model
{
    use HasFactory,RelationshipTrait;
    protected $connection = 'tenant';
    protected $table = 'development_profile';
    protected $fillable = ['id', 'development_id', 'profile_id'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::bootRelationshipTrait(); 
    }

    public function profile()
{
    return $this->belongsTo(Profile::class, 'profile_id');
}
}
