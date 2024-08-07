<?php 

namespace App\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Illuminate\Support\Facades\Auth;


class JWT {

    public function attempt($post) {
        if (auth()->attempt(
            [
                'email' => $post['email'], 
                'password' => $post['password']
                // 'deleted_at' => null
            ]
            )) {
            $payload = JWTFactory::sub(auth()->user()->id)
            ->users(auth()->user())
            ->make();
        
            $token = JWTAuth::encode($payload);
            return self::respondWithToken($token->get());
        }
    }

    public function attempt_sso($get_user) {
            $payload = JWTFactory::sub($get_user->id)
            ->users($get_user)
            ->make();
        
            $token = JWTAuth::encode($payload);
            return self::respondWithToken($token->get());
    }

    public function getUser() {
        $payload = JWTAuth::parseToken()->getPayload();
        // dd($payload);
        return $payload->get('users');
    }

    protected function respondWithToken($token)
    {
        return Response::success('Success', [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 600
        ]);
    }

}
