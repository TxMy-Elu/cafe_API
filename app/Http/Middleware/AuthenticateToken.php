<?php

        namespace App\Http\Middleware;

        use Closure;
        use Illuminate\Http\Request;
        use App\Models\Users;
        use Illuminate\Support\Facades\Log;

        class AuthenticateToken
        {
            public function handle(Request $request, Closure $next)
            {
                $token = $request->header('Authorization');
                Log::info('Authorization Header: ' . $token);

                // Remove 'Bearer ' prefix if present
                if (strpos($token, 'Bearer ') === 0) {
                    $token = substr($token, 7);
                }

                $user = Users::where('token', $token)->first();

                if (!$token) {
                    Log::warning('No token provided');
                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                if (!$user) {
                    Log::warning('Unauthorized access attempt with token: ' . $token);
                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                Log::info('User authenticated: ' . $user->login);

                return $next($request);
            }
        }