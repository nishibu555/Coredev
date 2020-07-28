<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Wish;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repository\Wishlist\WishlistRepository;

class WishController extends Controller
{
    protected $wishRepo;

    public function __construct(WishlistRepository $wishRepo)
    {
        $this->wishRepo = $wishRepo;
    }

    public function index(Request $request, $userId)
    {
        $wishes = $this->wishRepo->getWishList($userId);
        return $this->json('Wishes found successfully', Wish::collection($wishes));
    }
}
