<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
final class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Create User
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->create(data: $request->all());

            return self::successWithData(message: 'User Create Successfully', data: $user, httpStatusCode: Response::HTTP_CREATED);
        } catch (\Exception $e){
            return self::error(message: $e->getMessage(), httpStatusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * User authentication
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);

            if (! $token = auth()->attempt($credentials)) {
                return self::error(message: 'Unauthorized', httpStatusCode: Response::HTTP_UNAUTHORIZED);
            }

            return $this->respondWithToken(token: $token);
        }catch (\Exception $e){
            return self::error(message: $e->getMessage(), httpStatusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(token: Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
