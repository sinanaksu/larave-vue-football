<template>
    <div id="app" class="pt-5">
        <div class="container mb-4 p-3 rounded-3">
            <div class="row">
                <div class="col text-center">
                    <img src="images/logo.svg" width="200" />
                </div>
            </div>
        </div>
        <div class="container mb-4 p-3 bg-white rounded-3">
            <div class="row">
                <div class="col">
                    <button
                        class="btn btn-secondary btn-sm"
                        @click="newTournament()"
                    >
                        Create New Tournament
                    </button>
                    <button
                        class="btn btn-secondary btn-sm"
                        @click="newTournament()"
                    >
                        Generate Fixtures
                    </button>
                </div>
                <div class="col text-center">
                    <button class="btn btn-secondary btn-sm">
                        Play First Week
                    </button>
                </div>
                <div class="col text-end">
                    <button class="btn btn-secondary btn-sm">
                        Play All Weeks
                    </button>
                </div>
            </div>
        </div>
        <div class="container mb-4 p-3 bg-white rounded-3">
            <div v-if="teams.length">
                <h3 class="border-0 p-2 ps-3 pt-2">
                    <span>Teams</span>
                    <hr />
                </h3>
                <league-table :teams="teams" :detail="detail" />
            </div>
            <div v-else class="d-flex justify-content-center">
                <div class="spinner-grow text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getTeams, generateTournament } from "./services/team";
import leagueTable from "./components/leagueTable.vue";

export default {
    name: "App",
    data() {
        return {
            teams: {},
            detail: false,
        };
    },
    components: {
        leagueTable,
    },
    methods: {
        loadTeams() {
            getTeams().then((res) => {
                this.teams = res.data.data;
            });
        },
        newTournament() {
            this.teams = {};
            this.detail = false;
            generateTournament().then((res) => {
                this.teams = res.data.data;
            });
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
