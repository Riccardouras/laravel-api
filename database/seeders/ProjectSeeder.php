<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 50; $i++) {
            $project= new Project();

            $project-> title = $faker->sentence(3);
            $project-> content = $faker->text(500);
            $project-> image = "placeholders/placeholder.png";
            $project->save();

        }
    }
}