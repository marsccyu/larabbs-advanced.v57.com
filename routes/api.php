<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings', 'change-locale']
], function($api) {
    $api->group([
        // DingoApi 提供的調用頻率限制中間件 api.throttle, 設定在 config/api.php
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        /**
         *  遊客訪問接口
         */
        # 第三章
        // 短訊息驗證碼
        $api->post('verificationCodes', 'VerificationCodesController@store')
            ->name('api.verificationCodes.store');
        // 用戶註冊
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');
        // 圖片驗證碼
        $api->post('captchas', 'CaptchasController@store')
            ->name('api.captchas.store');
        # 第四章
        // 第三方登录
        $api->post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->name('api.socials.authorizations.store');
        // 登录
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');
        // 刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
        // 删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');
        # 第六章
        // 取得分類清單
        $api->get('categories', 'CategoriesController@index')
            ->name('api.categories.index');
        // 取得全部話題列表
        $api->get('topics', 'TopicsController@index')
            ->name('api.topics.index');
        // 取得單筆話題
        $api->get('topics/{topic}', 'TopicsController@show')
            ->name('api.topics.show');
        // 取得某用戶發表的話題
        $api->get('users/{user}/topics', 'TopicsController@userIndex')
            ->name('api.users.topics.index');
        # 第七章
        // 話題回覆列表
        $api->get('topics/{topic}/replies', 'RepliesController@index')
            ->name('api.topics.replies.index');
        // 某人的全部回覆列表
        $api->get('users/{user}/replies', 'RepliesController@userIndex')
            ->name('api.users.replies.index');
        //第九章
        // 資源推薦列表
        $api->get('links', 'LinksController@index')
            ->name('api.links.index');
        // 活躍用戶列表
        $api->get('actived/users', 'UsersController@activedIndex')
            ->name('api.actived.users.index');

        /**
         *  需 Token 驗證接口
         *  備註 : http 協議 put 和 patch 只能使用 x-www-form-urlencoded
         *  put 替換某個資源，需提供完整的資源信息 , patch 部分修改資源，提供部分資源信息
         */
        $api->group(['middleware' => 'api.auth'], function($api) {
            # 第五章
            // 當前登錄用戶信息
            $api->get('user', 'UsersController@me')
                ->name('api.user.show');
            // 編輯登錄用戶信息
            $api->patch('user', 'UsersController@update')
                ->name('api.user.update');
            // 圖片資源
            $api->post('images', 'ImagesController@store')
                ->name('api.images.store');
            # 第六章
            // 發布話題
            $api->post('topics', 'TopicsController@store')
                ->name('api.topics.store');
            // 修改話題
            $api->patch('topics/{topic}', 'TopicsController@update')
                ->name('api.topics.update');
            // 刪除話題
            $api->delete('topics/{topic}', 'TopicsController@destroy')
                ->name('api.topics.destroy');
            # 第七章
            // 發布回覆
            $api->post('topics/{topic}/replies', 'RepliesController@store')
                ->name('api.topics.replies.store');
            // 刪除回复
            $api->delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
                ->name('api.topics.replies.destroy');
            // 通知列表
            $api->get('user/notifications', 'NotificationsController@index')
                ->name('api.user.notifications.index');
            // 通知统计
            $api->get('user/notifications/stats', 'NotificationsController@stats')
                ->name('api.user.notifications.stats');
            // 标记消息通知为已读
            $api->patch('user/read/notifications', 'NotificationsController@read')
                ->name('api.user.notifications.read');
            # 第八章
            // 取得登錄用戶權限
            $api->get('user/permissions', 'PermissionsController@index')
                ->name('api.user.permissions.index');
        });
    });
});


$api->version('v2', function($api) {
    $api->get('version', function() {
        return response('this is version v2');
    });
});
