<?php

use Illuminate\Database\Seeder;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $user->each(function ($user) {
            factory(App\Thread::class, 3)->create(['user_id' => $user->id]);
        });
        $threads = factory(App\Thread::class, 50)->create();
        $threads->each(function ($thread) {
            factory(App\Reply::class, rand(1, 4))->create(['thread_id' => $thread->id]);
        });
    }
}
