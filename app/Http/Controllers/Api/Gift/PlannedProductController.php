<?php

namespace App\Http\Controllers\Api\Gift;

use App\Http\Controllers\Controller;
use App\Models\Gift\GiftPlan;
use App\Repository\Gift\GiftPlanRepository;
use App\Repository\Gift\PlannedProductRepository;
use Illuminate\Http\Request;

class PlannedProductController extends Controller
{
    /**
     * @var GiftPlanRepository
     */
    private $giftPlanRepo;
    private $plannedProductRepo;

    public function __construct(GiftPlanRepository $giftPlanRepo, PlannedProductRepository $plannedProductRepo)
    {
        $this->giftPlanRepo = $giftPlanRepo;
        $this->plannedProductRepo = $plannedProductRepo;
    }

    public function storePlannedProduct($planId, Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric',
	        'color_name' => 'nullable|string',
	        'color_code' => 'nullable|string',
	        'size' => 'nullable|string',
        ]);

        $giftPlan = $this->giftPlanRepo->findOrFail($planId);

        if($this->plannedProductRepo->countPlannedProduct($planId) >= 3) {
            return $this->json('planned product can not be more than 3!');
        }

        $productIds = $this->plannedProductRepo->getProductIds($planId);
        if (!$productIds->contains($request->product_id)) {
            $data = $this->formatPlannedProductData($giftPlan, $request->all());
            $this->plannedProductRepo->create($data);
            return $this->json('Planned product saved successfully!');
        }

        return $this->json('Product already exist in this plan!');

    }

    public function formatPlannedProductData(GiftPlan $giftPlan, $product)
    {
        return [
            'plan_id' => $giftPlan->id,
            'sender_id' => $giftPlan->sender->id,
            'product_id' => $product['product_id'],
            'color_name' => $product['color_name'] ?? '',
            'color_code' => $product['color_code'] ?? '',
            'size' => $product['size'] ?? ''
        ];
    }

    public function deletePlannedProduct($planId, $productId)
    {
        $this->giftPlanRepo->findOrFail($planId);
        if (!$this->plannedProductRepo->findProductByPlan($planId, $productId)) {
            return $this->json('Remove is not possible because this product does not exist in your list!');
        }
        if ($this->plannedProductRepo->deletePlannedProduct($planId, $productId)) {
            return $this->json('Planned product removed successfully!');
        }
    }
}
