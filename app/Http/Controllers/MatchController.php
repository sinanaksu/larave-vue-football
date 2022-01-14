<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\SkillController;
use PhpParser\Node\Expr\Match_;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matches = Match::orderBy('week', 'asc')
        ->get()
        ->toArray();
        foreach ($matches as $key => $value) {
            $matches[$key]["home_team"] = Team::select('name', 'logo', 'stadium')->where('id', $value["home_id"])
            ->get()
            ->toArray();
            $matches[$key]["away_team"] = Team::select('name', 'logo', 'stadium')->where('id', $value["away_id"])
            ->get()
            ->toArray();
        }

        return response()->json([
            'success' => true,
            'data' => $matches
        ]);
    }

    public function generateMatches()
    {
        $seeder = new \Database\Seeders\MatchSeeder();
        try {

            $seeder->run();
            return $this->index();

        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);

        }
    }


    public function getWeek() {
        $week = Match::select('week')->where('complated', 1)->orderBy('week', 'asc')->limit(1)->get()->toArray();
        return $week;
    }

    public function playAllWeek() {
        return $this->playNextWeek(99);
    }

     public function playNextWeek($limit = 2, $weeklist = false)
    {
        if(!$weeklist){
            $week_matches = Match::where('complated', 0)->orderBy('week', "asc")->limit($limit)
            ->get()
            ->toArray();

            foreach ($week_matches as $k => $v) {

                $home_power = SkillController::getTeamPower($v["home_id"],"home",$v["weather"]);
                $away_power = SkillController::getTeamPower($v["home_id"],"away",$v["weather"]);
                $difference = ($home_power-$away_power) < 0 ? ($away_power-$home_power) : ($home_power-$away_power);

                if($difference <= 0.5) {
                    // %100 Draw
                    $draw_score = rand(0,4);
                    $score1 = $draw_score;
                    $score2 = $draw_score;
                } else if ($difference > 0.5 && $difference <= 3) {
                    // %25 - %25 - %50
                    $score1 = rand(0,2);
                    $score2 = rand(1,5);
                } else {
                    // %25 - %75
                    $score1 = rand(0,2);
                    $score2 = rand(2,6);
                }

                if($home_power >= $away_power){
                    $score1 >= $score2 ? $home_score = $score1 : $home_score = $score2;
                    $score1 >= $score2 ? $away_score = $score2 : $away_score = $score1;
                } else{
                    $score1 >= $score2 ? $away_score = $score1 : $away_score = $score2;
                    $score1 >= $score2 ? $home_score = $score2 : $home_score = $score1;
                }

                $m = Match::findOrFail($v["id"]);
                $m->home_score = $home_score;
                $m->away_score = $away_score;
                $m->complated = 1;
                $m->save();

            }
        }

        $fixture_update = $this->applyResult();

        $week = Match::where('complated', 1)->orderBy('week', "desc")->limit(2)
        ->get()
        ->toArray();

        foreach ($week as $key => $value) {
            $week[$key]["home_team"] = Team::select('name', 'logo')->where('id', $value["home_id"])
            ->get()
            ->toArray();
            $week[$key]["away_team"] = Team::select('name', 'logo')->where('id', $value["away_id"])
            ->get()
            ->toArray();
        }

        return response()->json([
            'success' => true,
            'data' => $week
        ]);

    }

    public function applyResult()
    {

        $teams = Team::all()->toArray();

        foreach ($teams as $k => $team) {
            $array[$team["id"]]["played"] = 0;
            $array[$team["id"]]["win"] = 0;
            $array[$team["id"]]["drawn"] = 0;
            $array[$team["id"]]["lost"] = 0;
            $array[$team["id"]]["ga"] = 0;
            $array[$team["id"]]["gf"] = 0;

        }


        $matches = Match::where('complated', 1)->get()->toArray();
        foreach ($matches as $k => $match) {
                $array[$match["home_id"]]["played"] += 1;
                $array[$match["away_id"]]["played"] += 1;

                if ($match["home_score"] > $match["away_score"]) {

                    $array[$match["home_id"]]["win"] += 1;
                    $array[$match["home_id"]]["ga"] += $match["away_score"];
                    $array[$match["home_id"]]["gf"] += $match["home_score"];

                    $array[$match["away_id"]]["lost"] += 1;
                    $array[$match["away_id"]]["gf"] += $match["away_score"];
                    $array[$match["away_id"]]["ga"] += $match["home_score"];

                } else if($match["away_score"] > $match["home_score"]) {

                    $array[$match["away_id"]]["win"] += 1;
                    $array[$match["away_id"]]["ga"] += $match["home_score"];
                    $array[$match["away_id"]]["gf"] += $match["away_score"];

                    $array[$match["home_id"]]["lost"] += 1;
                    $array[$match["home_id"]]["gf"] += $match["home_score"];
                    $array[$match["home_id"]]["ga"] += $match["away_score"];

                } else if($match["away_score"] == $match["home_score"]) {

                    $array[$match["away_id"]]["drawn"] += 1;
                    $array[$match["away_id"]]["ga"] += $match["home_score"];
                    $array[$match["away_id"]]["gf"] += $match["away_score"];

                    $array[$match["home_id"]]["drawn"] += 1;
                    $array[$match["home_id"]]["gf"] += $match["home_score"];
                    $array[$match["home_id"]]["ga"] += $match["away_score"];

                }
        }


        foreach ($array as $key => $value) {

                $team = Team::findOrFail($key);
                $team->played = $value["played"];
                $team->win = $value["win"];
                $team->lost = $value["lost"];
                $team->drawn = $value["drawn"];

                $team->ga = $value["ga"];
                $team->gf = $value["gf"];
                $team->gd = $value["gf"] - $value["ga"];

                $team->points = ($value["win"]*3) + $value["drawn"];

                $team->save();
        }


        return true;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(Match $match)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Match $match)
    {
        $m = Match::findOrFail($request->id);
        $m->home_score = $request->home;
        $m->away_score = $request->away;
        $m->save();

        return $this->playNextWeek(2,true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Match $match)
    {
        //
    }
}
