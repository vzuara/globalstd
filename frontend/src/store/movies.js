import axios from 'axios';
import Swal from 'sweetalert2';
import moment from 'moment';
import { router } from './../router';

export const moviesModule = {
  state: {
    movie: {
      name: null,
      published_at: moment().format('YYYY-MM-DD'),
      status: false,
      image: null,
    },
  },
  getters: {},
  mutations: {
    setMovie(state, movie) {
      state.movie = movie;
    },
  },
  actions: {
    async getMovies(state) {
      const rootState = state.rootState;
      const { itemsPerPage, sortBy, page, sortDesc } = rootState;

      let queryString = '';
      itemsPerPage && (queryString += `&limit=${itemsPerPage}`);
      page && (queryString += `&page=${page}`);
      sortDesc && (queryString += `&ascending=${sortDesc}`);
      sortBy && (queryString += `&orderBy=${sortBy}`);

      try {
        const { data } = await axios.get(
          `${rootState.apiURL}/movies?${queryString}`
        );

        state.commit('setItems', data.data);
        state.commit('setTotalItems', data.count);
      } catch (error) {
        Swal.fire('Error', error.response.data.message, 'error');
      }
    },
    async getMovie(state, id) {
      const rootState = state.rootState;
      try {
        const { data } = await axios.get(`${rootState.apiURL}/movies/${id}`);
        state.commit('setMovie', data.movie);
      } catch (error) {
        Swal.fire('Error', error.response.data.message, 'error');
      }
    },
    async deleteMovie(state, id) {
      const rootState = state.rootState;
      try {
        await axios.delete(`${rootState.apiURL}/movies/${id}`);
        state.dispatch('getMovies');
        Swal.fire(
          'Felicidades',
          'El registro fue eliminado correctamente',
          'success'
        );
      } catch (error) {
        Swal.fire('Error', error.message, 'error');
      }
    },
    async saveMovie(state, { mode, data, id }) {
      console.log(data, mode, id);
      const rootState = state.rootState;
      const headers = {
        headers: {
          'Content-Type': 'multipart/form-data;',
        },
      };

      try {
        if (mode === 'create') {
          await axios.post(`${rootState.apiURL}/movies/`, data, headers);
        } else {
          await axios.post(`${rootState.apiURL}/movies/${id}`, data, headers);
        }
        state.dispatch('getMovies');
        Swal.fire(
          'Felicidades',
          'La informacion fue actualizada correctamente',
          'success'
        );
        router.push({ name: 'Movies' });
      } catch (error) {
        Swal.fire('Error', error.message, 'error');
      }
    },
  },
};
