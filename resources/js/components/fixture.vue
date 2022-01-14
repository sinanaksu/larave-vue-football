<template>
    <div class="row ps-1 pe-1">
        <div class="col-6" v-for="(w, index) of weeks" :key="index">
            <table class="table ">
                <thead class="bg-dark text-white">
                    <tr>
                        <th colspan="5">Week {{ w }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(match, index) of fixture.filter(m => m.week == w)" :key="index">
                        <td><img :src="match.home_team[0].logo" width="25" /></td>
                        <td>{{ match.home_team[0].name }}</td>
                        <td> - </td>
                        <td>{{ match.away_team[0].name }}</td>
                        <td><img :src="match.away_team[0].logo" width="25" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "fixture",
    props: {
        fixture: Array,
    },
    data(){
        return  {
        weeks: this.fixture.length/2
        }
    },
    methods: {
    }
};
</script>
