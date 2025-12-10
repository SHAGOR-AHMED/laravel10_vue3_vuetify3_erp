<template>
    <div>
        <v-app-bar app flat dense dark class="nav-color footer_bg">
            <v-app-bar-nav-icon router :to="{name: 'Dashboard'}">
                <img src="/all-assets/common/logo/cpb/cpbgroup.png" alt="room" height="40" width="40" contain
                    class="nav-logo-bg" />
            </v-app-bar-nav-icon>
            <v-spacer></v-spacer>

            <v-btn text small link router :to="{name: 'Dashboard'}" exact>
                Dashboard
            </v-btn>

            <v-btn text small link router :to="{name: 'er404'}">
                Error Page
            </v-btn>
        </v-app-bar>
    </div>
</template>

<style scoped>
    .v-btn--active {
        color: #fff;
        background: linear-gradient(90deg, #aa4b6b, #6b6b83, #3b8d99);
    }

    .nav-color {
        background: #aa4b6b;
        background: -webkit-linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
        background: linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
    }

    .nav-logo-bg {
        background-color: white !important;
        border-radius: 8px;
    }

    a:hover {
        text-decoration: none;
    }
</style>