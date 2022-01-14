<template>
    <div id="app" class="pt-5">
        <div class="container mb-4 p-3 rounded-3">
            <div class="row">
                <div class="col text-center">
                    <img src="images/logo.svg" width="150" />
                </div>
            </div>
        </div>
        <div class="container mb-4 p-3 bg-white rounded-3">
            <div class="row">
                <div class="col">
                    <button class="btn btn-secondary" @click="newTournament()">
                        Create New Tournament
                    </button>
                    <button class="btn btn-secondary" @click="newFixture()">
                        Generate Fixtures
                    </button>
                </div>
                <div class="col text-center">
                    <button
                        class="btn btn-secondary"
                        :disabled="screen < 2"
                        @click="nextWeek()"
                    >
                        Play Next Week
                    </button>
                </div>
                <div class="col text-end">
                    <button
                        class="btn btn-secondary"
                        :disabled="screen < 2"
                        @click="playAll()"
                    >
                        Play All Weeks
                    </button>
                </div>
            </div>
        </div>
        <div class="container mb-4 p-3 bg-white rounded-3">
            <div class="row">
                <div class="row" v-if="teams.length && screen == 3">
                    <div class="col-8">
                    <h3 class="border-0 p-2 ps-3 pt-2">
                        <span>League Table</span>
                        <hr />
                    </h3>
                    <league-table :teams="teams" :detail="true" />
                    </div>
                    <div class="col-4">
                    <h3 class="border-0 p-2 ps-3 pt-2">
                        <span>Match Results</span>
                        <hr />
                    </h3>
                    <league-table :teams="teams" :detail="false" />
                    </div>
                </div>

                <div v-if="teams.length && screen == 1">
                    <h3 class="border-0 p-2 ps-3 pt-2">
                        <span>Teams</span>
                        <hr />
                    </h3>
                    <league-table :teams="teams" :detail="false" />
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
import { generateFixture } from "./services/match";

import leagueTable from "./components/leagueTable.vue";
import fixture from "./components/fixture.vue";

export default {
    name: "App",
    data() {
        return {
            screen: 0,
            teams: {},
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
                this.screen = 1;
            });
        },
        newTournament() {
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
            getTeams().then((res) => {
                this.teams = res.data.data;
                this.screen = 3;
            });
        },
        playAll() {},
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
