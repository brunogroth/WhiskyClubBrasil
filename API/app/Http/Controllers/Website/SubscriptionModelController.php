<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\SubscriptionModelRequest;
use App\Http\Resources\Website\SubscriptionModelResource;
use App\Models\Website\SubscriptionModel;
use App\Traits\ResponseCreator;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SubscriptionModelController extends Controller
{

    use ResponseCreator;

    public function __construct(
        protected SubscriptionModel $model
    ) {
    }

    /**
     * Display a listing of the resource.
     * 
     * @return SubscriptionModelResource
     */
    public function index()
    {
        $subscriptionModels = $this->model->all();

        return SubscriptionModelResource::collection($subscriptionModels);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return JsonResponse|SubscriptionModelRequest
     */
    public function store(SubscriptionModelRequest $request): JsonResponse|SubscriptionModelResource
    {
        $data = $request->validated();

        $image_name = Carbon::now()->format('YmdHisu') .
            '.' . $request->image_url->getClientOriginalExtension();
        $data['image_url'] = $image_name;

        Storage::disk('subscription-models')->put($data['image_url'], file_get_contents($request->image_url));
        $subscriptionModel = $this->model->create($data);

        return new SubscriptionModelResource($subscriptionModel);
    }

    /**
     * Display the specified resource.
     * 
     * @return JsonResponse|SubscriptionModelRequest
     */
    public function show(int $id): JsonResponse|SubscriptionModelResource
    {
        $subscriptionModel = $this->model->findOrFail($id);

        return new SubscriptionModelResource($subscriptionModel);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @return JsonResponse NO CONTENT - 204
     */
    public function destroy(int $id): JsonResponse
    {
        try {

            $subscriptionModel = $this->model->findOrFail($id);

            Storage::disk('subscription-models')->delete($subscriptionModel->image_url);

            $subscriptionModel->delete();

            return response()->json([], JsonResponse::HTTP_NO_CONTENT);
        } catch (Throwable $error) {
            return $this->createResponseInternalError($error);
        }
    }
}
