<template>
    <div id="app">
        <div class="container">
            {{ test }}
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            test: "Sinan",
        };
    },
    components: {},
    methods: {},
    computed: {},
};
</script>

<style lang="css">
#app {
    min-height: 100vh;
    background-color: rgb(233, 233, 233);
}
</style>
