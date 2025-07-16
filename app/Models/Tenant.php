<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\str;
use App\Models\User;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = ['name','database'];
    public $incrementing=false;
    public $keyType="string";

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); 
        });
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function users()
    {
        return $this->hasMany(USer::class);
    }
}
