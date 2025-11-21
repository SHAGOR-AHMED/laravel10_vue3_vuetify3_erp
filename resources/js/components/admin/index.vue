<template>
    <v-app>
        <side-bar />
        <v-main>
            <div class="pa-3">
                <router-view></router-view>
                <vue3-progress />
            </div>
        </v-main>
        <page-footer></page-footer>
    </v-app>
</template>

<script>
import sideBar from './pages/common/sidebar.vue'
import pageFooter from './pages/common/footer.vue'

export default {

    props: ['authuser'],
    
    components:{
        'side-bar' : sideBar,
        'page-footer' : pageFooter,
    },
    
    mounted() {
        
    },

    created(){
       // Set Auth and Role data in Store
        this.$store.commit('setAuth', JSON.parse(this.authuser) )
        this.$progress.start();
        //console.log('Auth User: ', JSON.parse(this.authuser))
        this.$progress.finish();
    }
}
</script>
 