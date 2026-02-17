<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::factory(15)->create();
        
        $users = User::all();
        
        $events->each(function ($event) use ($users) {
            $event->users()->attach(
                $users->random(rand(3, min(8, $users->count())))->pluck('id')->toArray()
            );
        });
    }
}

