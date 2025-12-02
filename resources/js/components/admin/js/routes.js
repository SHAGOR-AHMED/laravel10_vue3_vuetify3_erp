import { createWebHistory, createRouter } from "vue-router";

import Dashboard from '../pages/dashboard.vue'
import UserIndex from '../pages/user/index.vue'
import EmployeeIndex from '../pages/employee/index.vue'
import RoleIndex from '../pages/role/index.vue'

const routes = [
  {
    path: '/',
    component: Dashboard,
    name: 'Dashboard',
    meta:{
      title: 'Admin Dashboard',
    },
  },
  {
    path: '/admin/dashboard',
    component: Dashboard,
    name: 'Dashboard',
    meta:{
      title: 'Admin Dashboard',
    },
  },

  {
    path: '/admin/user',
    component: UserIndex,
    name: 'UsersIndex',
    meta:{
      title: 'User Dashboard',
    },
  },

  {
    path: '/admin/role',
    component: RoleIndex,
    name: 'RoleIndex',
    meta:{
      title: 'Role Dashboard',
    },
  },

  {
    path: '/admin/employee',
    component: EmployeeIndex,
    name: 'EmployeeIndex',
    meta:{
      title: 'Employee Dashboard',
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

  let appName = 'My Project - ';
  let title = to.meta && to.meta.title ? to.meta.title : '';
  // set current title
  document.title =`${ appName } ${ title }`;

  next();
});

export default router;