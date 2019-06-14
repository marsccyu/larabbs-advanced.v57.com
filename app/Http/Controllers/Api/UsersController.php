<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Image;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Api\UserRequest;

class UsersController extends Controller
{
    public function activedIndex(User $user)
    {
        return $this->response->collection($user->getActiveUsers(), new UserTransformer());
    }

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

        return $this->response->item($user, new UserTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('api')->fromUser($user),
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
            ])
            ->setStatusCode(201);
    }

    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }

    public function update(UserRequest $request)
    {
        $user = $this->user();

        $attributes = $request->only(['name', 'email', 'introduction']);

        if ($request->avatar_image_id) {
            $image = Image::find($request->avatar_image_id);

            $attributes['avatar'] = $image->path;
        }
        $user->update($attributes);

        return $this->response->item($user, new UserTransformer());
    }
}
