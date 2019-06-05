<?php

use App\Models\User;
use App\Models\Thread;
use Illuminate\Database\Seeder;

class ThreadsTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);

        // 所有用户 ID 数组，如：[1,2,3,4]
        $user_ids = User::all()->pluck('id')->toArray();

        $threas = factory(Thread::class)->times(10)->make()
            ->each(function ($reply, $index)
            use ($user_ids, $faker)
            {
                // 从用户 ID 数组中随机取出一个并赋值
                $reply->user_id = $faker->randomElement($user_ids);
            });

        // 将数据集合转换为数组，并插入到数据库中
        Thread::insert($threas->toArray());
    }
}
