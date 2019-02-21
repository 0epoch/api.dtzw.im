<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends BaseController
{
    //
    public function signup()
    {
        $attributer = request(['name', 'email', 'password']);
        $user = new User();
        $user->name = $attributer['name'];
        $user->email = $attributer['email'];
        $user->password = bcrypt($attributer['password']);
        $user->save();
        return $this->success($user);
    }

    public function login()
    {
        $certify = request(['email', 'password']);
        if(!$token = auth('api')->attempt($certify)) {
            return response()->json(['error' => '认证失败'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout(){

        auth('api')->logout();
        return response()->json(['message' => '成功退出']);
    }

    /**
     * Refresh a token.
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    private function respondWithToken($token)
    {
        return response([
            'access_token' => $token,
            'token_type'   => 'bearea',
            'expires_in'   => auth('api')->factory()->getTTL(),
            'user'         => auth('api')->user(),
        ]);
    }
}
