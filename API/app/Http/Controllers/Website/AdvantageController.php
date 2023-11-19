<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreUpdateAdvantageRequest;
use App\Http\Resources\Website\AdvantageResource;
use App\Models\Website\Advantage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdvantageController extends Controller
{
    public function __construct(
        protected Advantage $repository
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advantages = $this->repository->all();

        return AdvantageResource::collection($advantages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateAdvantageRequest $request): JsonResponse | AdvantageResource
    {
        $data = $request->validated();

        $advantage = $this->repository->create($data);


        return new AdvantageResource($advantage);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse | AdvantageResource
    {
        $advantage = $this->repository->findOrFail($id);

        return new AdvantageResource($advantage);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateAdvantageRequest $request, int $id): JsonResponse | AdvantageResource
    {
        $advantage = $this->repository->findOrFail($id);
        $data = $request->validated();

        $advantage->update($data);

        return new AdvantageResource($advantage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $advantage = $this->repository->findOrFail($id);

        $advantage->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
