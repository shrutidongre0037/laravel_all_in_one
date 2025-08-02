<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelEventLogger;

class DepartmentDevelopment extends Model
{
    use HasFactory,ModelEventLogger;

    protected $connection = 'tenant';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'department_id', 'development_id', 'assigned_by', 'assigned_at'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function development()
    {
        return $this->belongsTo(Development::class);
    }
}
