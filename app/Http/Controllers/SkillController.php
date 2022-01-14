<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{

    public function getTeamPower($id,$area,$weather)
    {
        $skills = Skill::findOrFail($id);
        $total = 0;
        $total += $skills->goalkeeper;
        $total += $skills->defense;
        $total += $skills->attack;
        $area == "home" ? $total += $skills->home : $total += $skills->away;
        $weather == "clear" ? $total += $skills->weather_clear : '';
        $weather == "rain" ? $total += $skills->weather_rain : '';
        $weather == "snow" ? $total += $skills->weather_snow : '';
        return $total;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
