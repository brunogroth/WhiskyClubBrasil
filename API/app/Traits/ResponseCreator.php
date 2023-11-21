<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseCreator
{
    public function createResponse(int $statusCode, string $message = null, $data = [], $errors = [])
    {
        return response()->json(
            [
                "status-code" => $statusCode,
                "message" => $message,
                "data" => $data,
                "errors" => $errors
            ],
            $statusCode
        );
    }

    public function createResponseSuccess($data = [], $codeSuccess = Response::HTTP_OK, $message = null)
    {
        return $this->createResponse($codeSuccess, $message ?? "success", $data);
    }

    public function createResponseNotFound($message = null, $errors = null)
    {
        return $this->createResponse(Response::HTTP_NOT_FOUND, $message ?? "Not Found.", [], $errors);
    }

    public function createResponseBadRequest($message = null, $errors = null, int $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return $this->createResponse($statusCode, $message ?? "fail", [], $errors);
    }

    public function createResponseInternalError($errors = null)
    {
        return $this->createResponse(Response::HTTP_INTERNAL_SERVER_ERROR, "fail", [], $errors->getMessage());
    }

    public function createResponseForbbiden()
    {
        return $this->createResponse(Response::HTTP_FORBIDDEN, "fail", [], "Forbbiden.");
    }
}
