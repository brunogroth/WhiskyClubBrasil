<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreUpdateAdvantageRequest;
use App\Http\Resources\Website\AdvantageResource;
use App\Models\Website\Advantage;

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
    public function store(StoreUpdateAdvantageRequest $request): AdvantageResource
    {
        $data = $request->validated();

        $advantage = $this->repository->create($data);


        return new AdvantageResource($advantage);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateAdvantageRequest $request, Advantage $advantage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
    }
}
