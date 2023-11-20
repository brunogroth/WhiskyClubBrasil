<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreUpdateWorkingStepRequest;
use App\Http\Resources\Website\WorkingStepResource;
use App\Models\Website\WorkingStep;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WorkingStepController extends Controller
{
    public function __construct(
        protected WorkingStep $repository
    ) {
    }
    /**
     * Display a listing of the resource.
     * 
     * @return WorkingStepResource
     */
    public function index()
    {
        $workingSteps = WorkingStep::all();
        $workingStepsResource = WorkingStepResource::collection($workingSteps);

        return $workingStepsResource;
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return JsonResponse|WorkingStepResource
     */
    public function store(StoreUpdateWorkingStepRequest $request): JsonResponse|WorkingStepResource
    {
        $data = $request->validated();

        $workingStep = $this->repository->create($data);

        return new WorkingStepResource($workingStep);
    }

    /**
     * Display the specified resource.
     * 
     * @return JsonResponse|WorkingStepResource
     */
    public function show(string $id): JsonResponse|WorkingStepResource
    {
        $workingStep = $this->repository->findOrFail($id);

        return new WorkingStepResource($workingStep);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @return JsonResponse|WorkingStepResource
     */
    public function update(StoreUpdateWorkingStepRequest $request, string $id)
    {
        $workingStep = $this->repository->findOrFail($id);
        $data = $request->validated();

        $workingStep->update($data);

        return new WorkingStepResource($workingStep);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @return JsonResponse NO CONTENT - 204
     */
    public function destroy(string $id)
    {
        $workingStep = $this->repository->findOrFail($id);
        $workingStep->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
