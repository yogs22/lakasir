<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckValidation extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $req = [
            $request->key => $request->value
        ];
        if (in_array('confirmation', $request->validation)) {
            $keyConfirmed = explode('_', $request->key)[0];
            $req[$keyConfirmed] = $request->keyConfirmed;
        }
        $validator = Validator::make($req, [
            $request->key => $request->validation
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 422);
        } else {
            return response()->json(true, 200);
        }
    }
}
