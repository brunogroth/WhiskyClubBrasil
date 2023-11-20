<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreUpdateCommonQuestionRequest;
use App\Http\Resources\Website\CommonQuestionResource;
use App\Models\Website\CommonQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommonQuestionController extends Controller
{

    public function __construct(
        protected CommonQuestion $repository
    ) {
    }

    /**
     * Display a listing of the resource.
     * 
     * @return CommonQuestionResource
     */
    public function index()
    {
        $commonQuestions = $this->repository->all();
        $commonQuestionsResource = CommonQuestionResource::collection($commonQuestions);

        return $commonQuestionsResource;
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return JsonResponse|CommonQuestionResource
     */
    public function store(StoreUpdateCommonQuestionRequest $request): JsonResponse|CommonQuestionResource
    {
        $dataCommonQuestion = $request->validated();

        $commonQuestion = $this->repository->create($dataCommonQuestion);

        return new CommonQuestionResource($commonQuestion);
    }

    /**
     * Display the specified resource.
     * 
     * @return JsonResponse|CommonQuestionResource
     */
    public function show(int $id): JsonResponse|CommonQuestionResource
    {
        // $commonQuestion = CommonQuestion::find($id);
        // $commonQuestion = CommonQuestion::where('id', $id)->first();
        // if (!$commonQuestion) {
        //     return response()->json(['message' => 'Common Question not found'], Response::HTTP_NOT_FOUND);
        // }

        $commonQuestion = $this->repository->findOrFail($id);

        return new CommonQuestionResource($commonQuestion);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @return JsonResponse|CommonQuestionResource
     */
    public function update(StoreUpdateCommonQuestionRequest $request, int $id): JsonResponse|CommonQuestionResource
    {
        $commonQuestion = $this->repository->findOrFail($id);
        $data = $request->validated();

        $commonQuestion->update($data);

        return new CommonQuestionResource($commonQuestion);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @return JsonResponse NO CONTENT - 204
     */
    public function destroy(int $id): JsonResponse
    {
        $commonQuestion = $this->repository->findOrFail($id);
        $commonQuestion->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
