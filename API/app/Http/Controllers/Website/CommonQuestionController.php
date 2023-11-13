<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreUpdateCommonQuestionRequest;
use App\Http\Resources\Website\CommonQuestionResource;
use App\Models\Website\CommonQuestion;
use Illuminate\Http\Request;

class CommonQuestionController extends Controller
{
    public function index()
    {
        $commonQuestions = CommonQuestion::all();
        $commonQuestionsRequest = CommonQuestionResource::collection($commonQuestions);

        return $commonQuestionsRequest;
    }

    public function create(StoreUpdateCommonQuestionRequest $request)
    {
        $dataCommonQuestion = $request->validated();
        $commonQuestion = CommonQuestion::create($dataCommonQuestion);

        return response()->json(new CommonQuestionResource($commonQuestion));
    }
}
