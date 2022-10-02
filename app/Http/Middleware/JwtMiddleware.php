<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $header = explode(' ', $request->header('Authorization'));
        $token = $header[1];

        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'message'=> false,
                'error' => 'Token not provided.'
            ], 401);
        }
 
        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch(ExpiredException $e) {
            return response()->json([
                'success'=> false,
                'message' => 'Provided Token is expired, please re-login to fix this issue.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'success'=> false,
                'message' => 'An error while decoding Token.'
            ], 400);
        }

        $user = User::find($credentials->data->id);
        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;
        return $next($request);
    }
}
