<?php

namespace App\Http\Controllers\Api\Gift;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Gift\TimelineRequest;
use App\Http\Resources\Api\Gift\Timeline;
use App\Models\Gift\Gift;
use App\Repository\Gift\TimelineRepository;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    protected $timelineRepo;

    public function __construct(TimelineRepository $timelineRepo)
    {
        $this->timelineRepo = $timelineRepo;
    }


    public function index()
    {
        $gifts = $this->timelineRepo->getByUserId(auth()->id());

        return $this->json('Gifts of timeline', Timeline::collection($gifts));
    }

    public function report()
    {
        $gifts = $this->timelineRepo->getReportByUserId(auth()->id());

        return $this->json('Gifts Report of timeline', $gifts);
    }

    public function store(TimelineRequest $request)
    {
       $timelineGift = $this->timelineRepo->create(array_merge(
            $request->all(),
            ['user_id' => auth()->id()]
        ));

        return $this->json('Gift saved successfully!', new Timeline($timelineGift));
    }

    public function sent(Request $request)
    {
        $sentGifts = $this->timelineRepo->sentGiftByUserId(auth()->id(), $request->get('limit'));

        return $this->json('Get sent gifts successfully!', Timeline::collection($sentGifts));
    }

    public function received(Request $request)
    {
        $receivedGifts = $this->timelineRepo->receivedGiftByUserId(auth()->id(), $request->get('limit'));

        return $this->json('Get received gifts successfully!', Timeline::collection($receivedGifts));
    }


    public function delete(int $timelineId)
    {
        $this->timelineRepo->model()::where('id', $timelineId)->delete();

        return $this->json('Gift removed successfully!');
    }

    public function update(Request $request, int $timelineId)
    {
        $timeline = $this->timelineRepo->findOrFail($timelineId);
        if (!$timeline->gift_plan_id) {
            $timeline->update($request->all());
            return $this->json('Timeline updated successfully!', new Timeline($timeline));
        }

        return $this->json('Timeline update is not possible!');
    }
}
