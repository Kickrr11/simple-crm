<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;


class ApiController extends Controller
{
    /**
     *  To do
     */
    public function register() {}

    /**
     *
     * @param LoginRequest $loginRequest
     *
     * @throw /Exception
     * @response {
     * "data": {
     *  "access_token": "eyJ0eXA...",
     *  "token_type": "Bearer",
     *   "expires_at": "2022-..."
     * }
     * @unauthenticated
     */

    public function login(LoginRequest $loginRequest): Response
    {
        try {
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                throw new \Exception('Unauthorized', 401);
            }
            $user = User::where("email", $loginRequest->email)->first();
            $token = $user->createToken('Personal Access Token');
            return ResponseBuilder::success(
                [
                    'access_token' => $token->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $token->token->expires_at
                    )->toDateTimeString()
                ], 200);
        } catch (\Throwable $throwable) {
            return ResponseBuilder::error($throwable->getCode(), ["login" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }
}
