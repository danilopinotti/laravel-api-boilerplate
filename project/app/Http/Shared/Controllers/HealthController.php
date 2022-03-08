<?php

namespace App\Http\Shared\Controllers;

use Illuminate\Http\Request;

class HealthController extends Controller
{
    /**
     * Return request user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            'status' => 'success',
        ]);
    }
}
