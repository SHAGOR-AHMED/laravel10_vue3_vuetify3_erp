<template>
    <v-app>
        <nav-bar></nav-bar>
        <v-main>
            <router-view></router-view>
        </v-main>
        <page-footer></page-footer>
    </v-app>
</template>

<script>
import navBar from './pages/common/navbar.vue'
import pageFooter from './pages/common/footer.vue'
export default {

    components:{
        'nav-bar'     : navBar,
        'page-footer' : pageFooter,
    },

    data(){
        return{

        }
    },

    methods:{
       
    },

    mounted() {
        
    },

    created(){

    }
}
</script>

<style lang="scss">

</style>