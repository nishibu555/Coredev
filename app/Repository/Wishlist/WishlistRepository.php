<?php

namespace Repository\Wishlist;

use App\Http\Resources\Api\User\VerificationCode;
use App\Models\Wish;
use Repository\Repository;
use Auth;

class WishlistRepository extends Repository
{
    public function model()
    {
        return Wish::class;
    }

    public function getWishList($userId)
    {
        return $this->model()::where('user_id', $userId)->get();
    }

    public function updateWish($id, $userId, $status)
    {
        return $this->model()::where('id', $id)
                            ->where(['user_id' => $userId])
                            ->update(['status' => $status]);
    }

    public function deleteWish($id, $userId)
    {
       return $this->model()::where('id', $id)
                            ->where(['user_id' => $userId])
                            ->delete();
    }

    public function findByProduct($userId, $productId)
    {
        return $this->model()::where('user_id', $userId)->where('product_id', $productId)->first();
    }
}
