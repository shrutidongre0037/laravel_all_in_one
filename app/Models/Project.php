<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelEventLogger;


class Project extends Model
{
    use HasFactory;

    use SoftDeletes,ModelEventLogger;

    protected $connection = 'tenant';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['title', 'description', 'start_date', 'end_date'];

   

    public function getRouteKeyName()
    {
        return 'id'; // Ensures route model binding uses UUID
    }

    public function developments()
    {
        return $this->belongsToMany(Development::class);
    }
}
