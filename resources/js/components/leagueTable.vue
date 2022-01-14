<template>
    <div class="row ps-1 pe-1">
        <div class="col">
            <table class="table">
                <thead class="bg-dark text-white">
                    <tr>
                        <th width="55"></th>
                        <th>Team Name</th>
                        <th v-if="!detail">Stadium</th>
                        <th v-if="detail">M</th>
                        <th v-if="detail">W</th>
                        <th v-if="detail">D</th>
                        <th v-if="detail">L</th>
                        <th v-if="detail">GF</th>
                        <th v-if="detail">GA</th>
                        <th v-if="detail">GD</th>
                        <th v-if="detail">P</th>
                        <th class="text-center bg-warning text-dark" v-if="week == 4 || week == 5">ODDS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(team, index) of teams" :key="index">
                        <td><img :src="team.logo" width="25" /></td>
                        <td>{{ team.name }}</td>
                        <td v-if="!detail">{{ team.stadium }}</td>
                        <td v-if="detail">{{ team.played }}</td>
                        <td v-if="detail">{{ team.win }}</td>
                        <td v-if="detail">{{ team.drawn }}</td>
                        <td v-if="detail">{{ team.lost }}</td>
                        <td v-if="detail">{{ team.gf }}</td>
                        <td v-if="detail">{{ team.ga }}</td>
                        <td v-if="detail">{{ team.gd }}</td>
                        <td v-if="detail">{{ team.points }}</td>
                        <td class="text-center bg-warning" v-if="week == 4 || week == 5">{{ team.odds }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "leagueTable",
    props: {
        teams: Array,
        detail: Boolean,
        week: Number
    }
};
</script>
