<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RelationshipTrait;
use App\Traits\ModelEventLogger;

class Profile extends Model
{
    use HasFactory,ModelEventLogger,RelationshipTrait;

    protected $connection = 'tenant';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'linkedin', 'github'];

   
}
