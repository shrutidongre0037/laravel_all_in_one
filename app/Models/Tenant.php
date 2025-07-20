<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\str;
use App\Models\User;
use App\Traits\ModelEventLogger;


class Tenant extends Model
{
    use HasFactory,ModelEventLogger;

    protected $fillable = ['name','database'];
    public $incrementing=false;
    public $keyType="string";

   

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function users()
    {
        return $this->hasMany(USer::class);
    }
}
