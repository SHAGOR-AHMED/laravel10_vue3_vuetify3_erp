<template>
    <v-app-bar app flat dense dark class="bg_gradient">
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-spacer></v-spacer>
        <v-btn icon @click="toggle()">
            <v-icon v-if="fullscreen">mdi-fullscreen</v-icon>
            <v-icon v-else>mdi-fullscreen-exit</v-icon>
        </v-btn>
        <span v-if="auth" class="m-1">{{ auth.name }}</span>
    </v-app-bar>
    <!-- sidebar -->
    <!-- href="/" hit the web.php -->
    <!-- :to="{name: 'Dashboard'}" hit the routes.js  -->
    <v-navigation-drawer permanent dark v-model="drawer" class="bg_gradient" color="surface-variant" :width="200">
        <template v-slot:prepend>
            <v-list-item
                lines="two"
                prepend-avatar="https://randomuser.me/api/portraits/women/81.jpg"
                subtitle="Logged in"
                :title="auth.name"
            ></v-list-item>
        </template>
        <v-divider></v-divider>
        <v-list
        density="compact"
        nav
        >
            <v-list-item prepend-icon="mdi-view-dashboard" title="Home" value="home"  link router :to="{name: 'Dashboard'}" exact></v-list-item>
            <v-list-item prepend-icon="mdi-view-dashboard" title="User" value="User" link router :to="{name: 'UsersIndex'}"></v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        data() {
            return {
                fullscreen: true,
                drawer: true,
            };
        },
        methods: {
            toggle() {
                this.fullscreen = !this.fullscreen
                if(this.fullscreen == false){
                    this.expand();
                }else{
                    this.exitExpand();
                }
            },
            expand() {
                var elem = document.documentElement;
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                }
            },
            exitExpand() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            },
        },

    };
</script>

<style scoped>
    
</style>
