<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Team;
use Illuminate\Http\Request;

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
            $matches[$key]["sss"] = $value["home_id"];
            $matches[$key]["home_team"] = Team::select('name', 'logo')->where('id', $value["home_id"])
            ->get()
            ->toArray();
            $matches[$key]["away_team"] = Team::select('name', 'logo')->where('id', $value["away_id"])
            ->get()
            ->toArray();
        }

        return response()->json([
            'success' => true,
            'data' => $matches
        ]);
    }

    public function generateMatches(Request $request)
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
        //
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
