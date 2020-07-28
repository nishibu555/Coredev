<?php


namespace Repository\Product;

use App\Models\Favorite;
use Illuminate\Support\Collection;
use Repository\Repository;

class FavoriteRepository extends Repository
{

    public function model()
    {
        return Favorite::class;
    }

    public function favoriteProducts($userId):Collection
    {
        return $this->model()::where('user_id', $userId)->get();
    }

    public function storeFavorite($userId, $productId)
    {
        $this->model()::updateOrCreate([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }

    public function findByProduct($userId, $productId)
    {
        return $this->model()::where('user_id', $userId)->where('product_id', $productId)->first();
    }
}
