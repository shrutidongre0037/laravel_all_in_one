<?php

namespace App\Repositories\Interfaces;

interface MarketingRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id , array $data);
    public function delete($id);
    public function restore($id);
    public function forceDelete($id);


}