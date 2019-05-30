<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = Cache::get($request->verification_key);

        if (!$verifyData) {
            return $this->response->error('驗證碼失效', 422);
        }

        /**
         * 為了防止時序攻擊使用 hash_equals , 但會遇到錯誤 => hash_equals(): Expected known_string to be a string, integer given
         * 註 : 將第一個參數轉為字串後可以解決
         */
        if (!hash_equals((string)$verifyData['code'] , $request->verification_code)) {
            // 返回401
            return $this->response->errorUnauthorized('驗證碼錯誤');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        // 清除验证码缓存
        Cache::forget($request->verification_key);

        return $this->response->created();
    }
}
