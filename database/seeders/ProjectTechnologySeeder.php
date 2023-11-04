<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProjectTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
       $projects= Project::all();                       // object Post
       $technologies = Technology::all()->pluck('id')->toArray(); // array  [1, 2, ... n]
    
      foreach($projects as $project) {
        $project
          ->technologies()
          ->attach($faker->randomElements($technologies, random_int(0, 3)));
      }
    }
}
