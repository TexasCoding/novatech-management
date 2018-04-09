<template>
    <div>
        <nav-bar-component></nav-bar-component>
        <div role="main" class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import NavBarComponent from '../components/NavBarComponent';

    export default {
        components: {
            NavBarComponent,
        }
    }
</script>

<style>
    body {
        min-height: 50rem;
        padding-top: 4.5rem;
    }
</style>
