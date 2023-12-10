<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\SubscriptionModelRequest;
use App\Http\Resources\Website\SubscriptionModelResource;
use App\Models\Website\SubscriptionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubscriptionModelController extends Controller
{
    public function __construct(
        protected SubscriptionModel $model
    ) {
    }

    public function index()
    {
        $subscriptionModels = $this->model->all();

        return SubscriptionModelResource::collection($subscriptionModels);
    }

    public function store(SubscriptionModelRequest $request): SubscriptionModelResource
    {
        $data = $request->validated();

        $image_name = Carbon::now()->format('YmdHisu') .
            '.' . $request->image_url->getClientOriginalExtension();
        $data['image_url'] = $image_name;

        Storage::disk('subscription-models')->put($data['image_url'], file_get_contents($request->image_url));
        $subscriptionModel = $this->model->create($data);

        return new SubscriptionModelResource($subscriptionModel);
    }
}
