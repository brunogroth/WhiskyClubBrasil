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

        $bannerData = $request->validated();
        $image_name = Carbon::now()->format('YmdHisu') .
            // '-' . strstr($request->image_url, '.', true) .
            '.' . $request->image_url->getClientOriginalExtension();

        $bannerData['image_url'] = $image_name;

        Storage::disk('banners')->put($image_name, file_get_contents($request->image_url));

        $banner = Banner::create($bannerData);

        $resource = $banner;
        $resource->image_url = asset('storage/banners/' . $image_name);

        return new BannerResource($resource);
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
//20231120230414