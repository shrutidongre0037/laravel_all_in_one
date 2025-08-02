<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelEventLogger;
use App\Traits\RelationshipTrait;


class Project extends Model
{
    use HasFactory, RelationshipTrait;

    use SoftDeletes,ModelEventLogger;

    protected $connection = 'tenant';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id','title', 'description', 'start_date', 'end_date', 'status', 'priority'];

   

    public function getRouteKeyName()
    {
        return 'id'; // Ensures route model binding uses UUID
    }

}
