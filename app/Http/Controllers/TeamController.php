<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::orderBy('points', 'desc')
        ->orderBy('gd', 'desc')
        ->orderBy('gf', 'desc')
        ->get()
        ->toArray();

        $week = ($teams[0]["played"]);
        $factor = 0;

        if($week == 4 || $week == 5) {
            $leader_points = ($teams[0]["points"]);
            $total = 0;
            foreach ($teams as $key => $value) {
                if(((6-$week) * 3) >= $leader_points-$value["points"]) {
                    $total += $value["points"];
                }
            }
            $factor = 100/$total;
            $case = 100;
            foreach ($teams as $key => $value) {
                $per = round(($value["points"]*$factor));
                $case = $case - $per;
                if($case <= 0){
                    $teams[$key]["odds"] = 0;
                } else if($per < $case){
                    $teams[$key]["odds"] = $per;
                } else {
                    $teams[$key]["odds"] = $case;
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $teams,
            'week' => $week,
            'factor' => $factor
        ]);
    }


    public function generateTournament(Request $request)
    {
        $seeder = new \Database\Seeders\TeamAndSkillSeeder();
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
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return "Id:" . $id;
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }
}
