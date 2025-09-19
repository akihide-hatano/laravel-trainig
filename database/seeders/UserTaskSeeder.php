<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = collect();

        $fixed = User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $users->push($fixed);

        User::factory(4)->create()->each(function ($u) use ($users) {
            $users->push($u);
        });

        foreach($users as $u){
            Task::factory()
                ->count(10)
                ->for($u)
                ->create();

                // 何件作れたか/例として2件のタイトル”をログに出す
                Log::info('seeded tasks for user', [
                    'user_id'    => $u->id,
                    'email'      => $u->email,
                    'task_count' => $u->tasks()->count(),
                    'examples'   => $u->tasks()->latest()->take(2)->pluck('title'),
                ]);

                // 全体件数のサマリもログへ
                Log::info('seeding done', [
                    'users_total' => $users->count(),
                    'tasks_total' => Task::count(),
                ]);
        }
    }
}
