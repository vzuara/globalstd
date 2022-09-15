import axios from 'axios';
import Swal from 'sweetalert2';
import { router } from './../router';

export const authModule = {
  state: {
    user: JSON.parse(localStorage.getItem('user')),
  },
  getters: {
    getName(state) {
      return state.user.name;
    },
    getInitials(state) {
      return state.user.name
        .concat(' ')
        .replace(/([a-zA-Z]{0,} )/g, function (match) {
          return match.trim()[0];
        });
    },
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
  },
  actions: {
    async sendLogin(state, { email, password }) {
      try {
        const { data } = await axios.post(`${state.rootState.apiURL}/login`, {
          email,
          password,
        });
        state.commit('setUser', data.user);
        localStorage.setItem('token', data.token);
        localStorage.setItem('user', JSON.stringify(data.user));
        router.push({ name: 'Dashboard' });
      } catch (error) {
        Swal.fire(
          'Error',
          'Sus datos son incorrectos favor de verificar',
          'error'
        );
      }
    },
  },
};
