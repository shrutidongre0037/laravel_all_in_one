<?php

namespace App\Repositories\Eloquent;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Support\Arr;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function all()
    {
        return Department::all();
    }

    public function find($id)  
    {
        return Department::findOrFail($id);
    }

    public function create(array $data)
    {
        $department=Department::create($data);
        return $department;
    }

    public function update($id, array $data)
    {
        $department=Department::findOrFail($id);
        $department=Department::update($data);
        return $department;
    }

     public function delete($id)
    {
        return Department::findOrFail($id)->delete();
    }

    public function restore($id)
    {
        return Department::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete($id)
    {
        return Department::withTrashed()->findOrFail($id)->forceDelete();
    }
}