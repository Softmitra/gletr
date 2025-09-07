<?php

namespace App\Repositories\Interfaces;

interface SellerStoreRepositoryInterface
{
    public function create(array $data);
    public function update(int $id, array $data);
    public function find(int $id);
    public function findBySellerId(int $sellerId);
    public function findBySlug(string $slug);
    public function delete(int $id);
    public function getActiveStores();
    public function getFeaturedStores($limit = 10);
    public function updateStoreStats(int $storeId, array $stats);
}
