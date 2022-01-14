<template>
    <div class="row ps-1 pe-1">
        <div class="col">
            <table class="table">
                <thead class="bg-dark text-white">
                    <tr>
                        <th width="55"></th>
                        <th>Team Name</th>
                        <th v-if="detail">Played</th>
                        <th v-if="detail">W</th>
                        <th v-if="detail">D</th>
                        <th v-if="detail">L</th>
                        <th v-if="detail">GF</th>
                        <th v-if="detail">GA</th>
                        <th v-if="detail">GD</th>
                        <th v-if="detail">Points</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(team, index) of teams" :key="index">
                        <td><img :src="team.logo" width="25" /></td>
                        <td>{{ team.name }}</td>
                        <td v-if="detail">{{ team.played }}</td>
                        <td v-if="detail">{{ team.win }}</td>
                        <td v-if="detail">{{ team.drawn }}</td>
                        <td v-if="detail">{{ team.lost }}</td>
                        <td v-if="detail">{{ team.gf }}</td>
                        <td v-if="detail">{{ team.ga }}</td>
                        <td v-if="detail">{{ team.gd }}</td>
                        <td v-if="detail">{{ team.points }}</td>
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
        detail: Boolean
    }
};
</script>
