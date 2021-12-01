<?php

namespace App\Http\MyService;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResponseService
{

    public static function wrapStatus(int $httpCode, bool $status, $data, $message = '')
    {
        $response = ['status' => ($status) ? 'OK' : 'NOK'];
        if($data != null){
            $response['data'] = $data;
        }

        if ($message != '') {
            $response['message'] = $message;
        }

        return response()->json($response, $httpCode);
    }

    public static function notFoundStatus()
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'status' => 'NOK',
                    'message' => 'Data Not Found',
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }

    public static function validationErrorStatus(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                [
                    'status' => 'NOK',
                    'message' => 'The given data was invalid.',
                    'errors' => $errors
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }

    public static function unauthorizedStatus()
    {

        throw new HttpResponseException(
            response()->json(
                [
                    'status' => 'NOK',
                    'message' => 'Not Authorized.',
                ],
                JsonResponse::HTTP_UNAUTHORIZED
            )
        );
    }
}
