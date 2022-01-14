<template>
    <div id="app" class="pt-5">
        <div class="container mb-4 p-3 rounded-3">
            <div class="row">
                <div class="col text-center">
                    <img src="images/logo.svg" width="150" />
                </div>
            </div>
        </div>
        <div class="container mb-4 p-3 rounded-3 text-primary bg-white" v-if="week == 6">
            <div class="row">
                <div class="col-5 text-end">
                    <img :src="teams[0].logo" width="100" />
                </div>
                <div class="col-7 text-start">
                    <h2>Champion</h2>
                    <h1>{{ teams[0].name }}</h1>
                </div>
            </div>
        </div>
        <div class="container mb-4 p-3 bg-white rounded-3">
            <div class="row">
                <div class="col">
                    <button class="btn btn-secondary" @click="newTournament()">
                        Create New Tournament
                    </button>
                </div>
                <div class="col text-center">
                    <button
                        class="btn btn-dark"
                        :disabled="screen < 2 || week == 6"
                        @click="nextWeek()"
                    >
                        Play Next Week
                    </button>
                </div>
                <div class="col text-end">
                    <button
                        class="btn btn-primary"
                        :disabled="screen < 2 || week == 6"
                        @click="playAll()"
                    >
                        Play All Week
                    </button>
                    <button class="btn btn-danger" @click="newTournament()">
                        Reset Data
                    </button>
                </div>
            </div>
        </div>
        <div class="container mb-4 p-3 bg-white rounded-3">
            <div class="row">
                <div class="row" v-if="teams.length && screen == 3">
                    <div class="col-7">
                    <h3 class="border-0 p-2 ps-3 pt-2">
                        <span>League Table</span>
                        <hr />
                    </h3>
                    <league-table :teams="teams" :detail="true" :week="week" />
                    </div>
                    <div class="col-5">
                    <h3 class="border-0 p-2 ps-3 pt-2">
                        <span>Match Results</span>
                        <hr />
                    </h3>
                    <table class="table">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th colspan="5">Week {{ week }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(match, ii) of weekResult" :key="ii">
                                <td><img :src="match.home_team[0].logo" width="25" /></td>
                                <td>{{ match.home_team[0].name }}</td>
                                <td>{{ match.home_score }} - {{ match.away_score }}</td>
                                <td>{{ match.away_team[0].name }}</td>
                                <td><img :src="match.away_team[0].logo" width="25" /></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>

                <div v-if="teams.length && screen == 1">
                    <h3 class="border-0 ps-3 pt-2 p-0">
                        <span>Teams</span>
                        <hr />
                    </h3>
                    <league-table :teams="teams" :detail="false"  :week="week"/>
                    <div class="row">
                        <div class="col text-center">
                        <button class="btn btn-dark" @click="newFixture()">
                            Generate Fixtures
                        </button>
                        </div>
                    </div>
                </div>

                <div v-if="fixture.length && screen == 2">
                    <h3 class="border-0 p-2 ps-3 pt-2">
                        <span>Generated Fixtures</span>
                        <hr />
                    </h3>
                    <fixture :fixture="fixture" />
                </div>

                <div class="d-flex justify-content-center" v-if="screen == 0">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getTeams, generateTournament } from "./services/team";
import { generateFixture, playNextWeek, playAllWeek } from "./services/match";

import leagueTable from "./components/leagueTable.vue";
import fixture from "./components/fixture.vue";

export default {
    name: "App",
    data() {
        return {
            screen: 0,
            teams: {},
            weekResult: {},
            week:0,
            fixture: [],
        };
    },
    components: {
        fixture,
        leagueTable,
    },
    methods: {
        loadTeams() {
            getTeams().then((res) => {
                this.teams = res.data.data;
                this.week = 0;
                this.screen = 1;
            });
        },
        newTournament() {
            this.week = 0;
            this.screen = 0;
            this.teams = {};
            generateTournament().then((res) => {
                this.teams = res.data.data;
                this.screen = 1;
            });
        },
        newFixture() {
            this.screen = 0;
            this.fixture = [];
            generateFixture().then((res) => {
                this.fixture = res.data.data;
                this.screen = 2;
            });
        },
        nextWeek() {
            this.screen = 0;
            this.teams = {};
            this.weekResult = {};

            playNextWeek().then((res) => {
                this.weekResult = res.data.data;

                getTeams().then((res) => {
                    this.teams = res.data.data;
                    this.week = res.data.week;
                    this.screen = 3;
                });

            })

        },
        playAll() {
            console.log("play all");
            this.screen = 0;
            this.teams = {};
            this.weekResult = {};

            playAllWeek().then((res) => {
                this.weekResult = res.data.data;

                getTeams().then((res) => {
                    this.teams = res.data.data;
                    this.week = res.data.week;
                    this.screen = 3;
                });

            })
        },
    },
    computed: {},
    created() {
        this.loadTeams();
    },
};
</script>

<style lang="css">
#app {
    min-height: 100vh;
    background-color: #06123a;
    background-image: url("assets/images/background.jpg");
    background-position: right bottom;
    background-size: cover;
    background-repeat: no-repeat;
}
</style>
