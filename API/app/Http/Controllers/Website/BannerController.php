<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreUpdateBannerRequest;
use App\Http\Resources\Website\BannerResource;
use App\Models\Website\Banner;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{

    public function __construct(
        protected Banner $repository
    ) {
    }

    /**
     * Display a listing of the resource.
     * 
     * @return BannerResource
     */
    public function index(): BannerResource
    {
        $banners = $this->repository->all();

        return BannerResource::collect($banners);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return BannerResource
     */
    public function store(StoreUpdateBannerRequest $request)
    {

        $bannerData = $request->validated();
        $image_name = Carbon::now()->format('YmdHis') .
            // '-' . strstr($request->image_url, '.', true) .
            '.' . $request->image_url->getClientOriginalExtension();

        Storage::disk('banners')->put($image_name, file_get_contents($request->image_url));
        $banner = Banner::create($bannerData);
        $resource = $banner;
        $resource->image_url = asset('storage/banners/' . $image_name);

        return new BannerResource($resource);
    }
}
