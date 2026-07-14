<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidCredentialsException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
