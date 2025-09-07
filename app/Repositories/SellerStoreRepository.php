<?php

namespace App\Repositories;

use App\Models\SellerStore;
use App\Repositories\Interfaces\SellerStoreRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SellerStoreRepository implements SellerStoreRepositoryInterface
{
    protected $model;

    public function __construct(SellerStore $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $store = $this->find($id);
        if ($store) {
            $store->update($data);
            return $store->fresh();
        }
        return null;
    }

    public function find(int $id)
    {
        return $this->model->with('seller')->find($id);
    }

    public function findBySellerId(int $sellerId)
    {
        return $this->model->where('seller_id', $sellerId)->first();
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('store_slug', $slug)->with('seller')->first();
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function getActiveStores()
    {
        return $this->model->active()->with('seller')->get();
    }

    public function getFeaturedStores($limit = 10)
    {
        return $this->model->featured()
            ->active()
            ->with('seller')
            ->limit($limit)
            ->orderBy('rating', 'desc')
            ->get();
    }

    public function updateStoreStats(int $storeId, array $stats)
    {
        return $this->model->where('id', $storeId)->update($stats);
    }
}
