<?php

namespace App\Repositories\Eloquent;

use App\Models\Marketing;
use App\Repositories\Interfaces\MarketingRepositoryInterface;

class MarketingRepository implements MarketingRepositoryInterface
{
    public function all()
    {
        return Marketing::all();
    }

     public function find($id)
    {
        return Marketing::findOrFail($id);
    }

    public function create(array $data)
    {
        $marketing=Marketing::create($data);
        return $marketing;
    }

    public function update($id, array $data)
    {
        $marketing=Marketing::findOrFail($id);
        $marketing->update($data);
        return $marketing;
    }

    public function delete($id)
    {
        return Marketing::findOrFail($id)->delete();
    }

    public function restore($id)
    {
        return Marketing::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete($id)
    {
        return Marketing::withTrashed()->findOrFail($id)->forceDelete();
    }
}