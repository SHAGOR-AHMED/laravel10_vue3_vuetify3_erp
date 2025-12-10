import { createWebHistory, createRouter } from "vue-router";

import Dashboard from './../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

const routes = [
    
    { 
        path: '/frontend', 
        component: Dashboard,
        name: 'Dashboard',
        meta:{
            title: 'Frontend Dashboard',
        },   
    },

    { 
        path: '/error', 
        component: er404,
        name: 'er404',
        meta:{
            title: 'Error',
        },   
    },
    

    { 
        path: '/*', 
        component: er404,
        name: 'er404',
        meta:{
            title: 'Room 404',
        },   
    },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});


// Run brfore every route request
router.beforeEach( (to, from, next) => {
    // console.log(to, to.meta);
 
    let appName = 'My Project Frontend - ';
    let title = to.meta && to.meta.title ? to.meta.title : '';
    // set current title
    document.title =`${ appName } ${ title }`;

    next();
});


export default router;