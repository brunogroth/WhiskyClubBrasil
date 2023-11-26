<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreUpdateBannerRequest;
use App\Http\Resources\Website\BannerResource;
use App\Models\Website\Banner;
use App\Traits\ResponseCreator;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Throwable;

class BannerController extends Controller
{

    use ResponseCreator;

    public function __construct(
        protected Banner $repository
    ) {
    }

    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse|BannerResource
     */
    public function index()
    {
        $banners = $this->repository->all();

        return BannerResource::collection($banners);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return BannerResource
     */
    public function store(StoreUpdateBannerRequest $request)
    {

        $data = $request->validated();
        $image_name = Carbon::now()->format('YmdHisu') .
            // '-' . strstr($request->image_url, '.', true) .
            '.' . $request->image_url->getClientOriginalExtension();

        $data['image_url'] = $image_name;

        Storage::disk('banners')->put($image_name, file_get_contents($request->image_url));

        $banner = $this->repository->create($data);

        $resource = $banner;
        $resource->image_url = asset('storage/banners/' . $image_name);

        return new BannerResource($resource);
    }

    /**
     * Display the specified resource.
     * 
     * @return BannerResource
     */
    public function show(int $id): JsonResponse|BannerResource
    {
        $banner = $this->repository->findOrFail($id);

        return new BannerResource($banner);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @return BannerResource
     */
    public function update(StoreUpdateBannerRequest $request, int $id): JsonResponse|BannerResource
    {
        try {
            $data = $request->validated();
            $banner = $this->repository->findOrFail($id);

            if (isset($data['image_url'])) {
                Storage::disk('banners')->delete($banner->image_url);
                $image_name = Carbon::now()->format('YmdHisu') .
                    // '-' . strstr($request->image_url, '.', true) .
                    '.' . $request->image_url->getClientOriginalExtension();

                Storage::disk('banners')->put($image_name, file_get_contents($request->image_url));

                $data['image_url'] = $image_name;
            }

            $banner->update($data);

            return new BannerResource($banner);
        } catch (Throwable $error) {
            dd($error);
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @return JsonResponse NO CONTENT - 204
     */
    public function destroy(int $id) //: JsonResponse
    {
        try {
            $banner = $this->repository->findOrFail($id);

            Storage::disk('banners')->delete($banner->image_url);

            $banner->delete();

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (Throwable $error) {
            return $this->createResponseInternalError($error);
        }
    }
}
