import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './../store';

import PublicLayout from './../components/layouts/PublicLayout.vue';
import PrivateLayout from './../components/layouts/PrivateLayout.vue';

import LoginComponent from './../components/auth/LoginComponent.vue';

import MoviesComponent from './../components/movies/MoviesComponent.vue';
import MovieFormComponent from './../components/movies/MovieFormComponent.vue';

import TurnsComponent from './../components/turns/TurnsComponent.vue';
import TurnFormComponent from './../components/turns/TurnFormComponent.vue';

import DashboardComponent from './../components/dashboard/DashboardComponent.vue';

import AssignmentsComponent from './../components/assignments/AssignmentsComponent.vue';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: PublicLayout,
    children: [
      {
        path: '',
        name: 'login',
        component: LoginComponent,
      },
    ],
  },
  {
    path: '/admin',
    component: PrivateLayout,
    children: [
      {
        path: '/',
        name: 'Dashboard',
        component: DashboardComponent,
      },
      {
        path: 'movies',
        name: 'Movies',
        component: MoviesComponent,
      },
      {
        path: 'movie',
        name: 'Movie',
        component: MovieFormComponent,
      },
      {
        path: 'turns',
        name: 'Turns',
        component: TurnsComponent,
      },
      {
        path: 'turn',
        name: 'Turn',
        component: TurnFormComponent,
      },
      {
        path: 'assignment',
        name: 'Assignment',
        component: AssignmentsComponent,
      },
      {
        path: 'logout',
        name: 'logout',
        component: {
          beforeRouteEnter(_to, _from, next) {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            store.state.authModule.user = null;
            next('/');
          },
        },
      },
    ],
  },
];

export const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach(async (to, _from, next) => {
  if (
    to.name === 'login' ||
    (to.path.includes('/admin') && localStorage.getItem('token'))
  ) {
    return next();
  }
  next({ name: 'login' });
});

export default router;
