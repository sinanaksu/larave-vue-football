<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Team;
use App\Models\Match;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Match::truncate();

        $matches = [];
        $teams = Team::get()->toArray();

        $array = $teams;
        for($i = 1; $i <= (count($array)-1)*2; $i++){
            if($i != (count($array)-1) && $i != (count($array)-1)*2) {
                $matches[] = [$array[1], $array[0],1];
                $matches[] = [$array[3], $array[2],1];
            } else {
                $matches[] = [$array[1], $array[3],1];
                $matches[] = [$array[0], $array[2],1];
            }
            $array = array($array[1],$array[2],$array[3],$array[0]);
        }

        $weather = array("clear","rainy","snowy");
        $week = 1;
        for ($i=0; $i < count($matches); $i++) {

            $round = new Match();
            $round->week = $week;
            $round->home_id = $matches[$i][1]["id"];
            $round->away_id = $matches[$i][0]["id"];
            $round->weather = Arr::random($weather);
            $round->save();

            if(($i+1)%2 == 0) { $week++; }
        }
    }
}

