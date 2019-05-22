<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SyncUserActivedAt extends Command
{
    protected $signature = 'larabbs:sync-user-actived-at';
    protected $description = '將用戶最後登入時間的 Redis 同步進資料庫中';

    public function handle(User $user)
    {
        $user->syncUserActivedAt();
        $this->info("同步成功！");
    }
}
