<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CalculateActiveUser extends Command
{
    // 供我们调用命令
    protected $signature = 'larabbs:calculate-active-user';

    // 命令的描述
    protected $description = '產生活躍用戶';

    // 最终执行的方法
    public function handle(User $user)
    {
        // 在命令行打印一行信息
        $this->info("開始計算...");

        $user->calculateAndCacheActiveUsers();

        $this->info("產生活躍用戶完成！");
    }
}
