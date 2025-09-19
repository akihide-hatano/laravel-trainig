<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserTaskSeeder extends Seeder
{
    public function run(): void
    {
        // 固定ユーザー + ランダム4人 = 合計5人
        $fixed  = User::factory()->create([
            'name'     => 'test',
            'email'    => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        $others = User::factory(4)->create();
        $users  = collect([$fixed])->concat($others);

        foreach ($users as $u) {
            $created = Task::factory()
                ->count(10)
                ->for($u)      // user_id を自動でセット
                ->create();    // ← ここがDB INSERT。戻り値は作成されたコレクション

            Log::info('seeded tasks for user', [
                'user_id'    => $u->id,
                'email'      => $u->email,
                'task_count' => $created->count(),
                'examples'   => $created->pluck('title')->take(2)->all(), // ← 配列で出す
            ]);
        }

        // まとめは1回だけ
        Log::info('seeding done', [
            'users_total' => $users->count(), // 5
            'tasks_total' => Task::count(),   // 50
        ]);
    }
}
