<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Team;
use App\Models\Skill;


class TeamAndSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::truncate();
        Skill::truncate();

        $faker = \Faker\Factory::create();

        $path = storage_path() . "/teams.json";
        $data = json_decode(file_get_contents($path),true);
        $teams = Arr::random($data, 4);

        foreach ($teams as $v) {
            $team = new Team();
            $team->name = $v["name"];
            $team->logo = $v["logo"];
            $team->stadium = $v["stadium"];
            $team->save();

            $skill = new Skill();
            $skill->team_id = $team->id;
            $skill->home = $faker->randomFloat(1, 0, 7);
            $skill->away = $faker->randomFloat(1, 0, 7);
            $skill->goalkeeper = $faker->randomFloat(1, 0, 5);
            $skill->defense = $faker->randomFloat(1, 0, 5);
            $skill->attack = $faker->randomFloat(1, 0, 5);
            $skill->weather_clear = $faker->randomFloat(1, 0, 9);
            $skill->weather_rain = $faker->randomFloat(1, 0, 9);
            $skill->weather_snow = $faker->randomFloat(10, 0, 9);
            $skill->save();
        }
    }
}
