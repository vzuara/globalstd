import axios from 'axios';
import Swal from 'sweetalert2';
import moment from 'moment';
import { router } from './../router';

export const turnsModule = {
  state: {
    turn: {
      turn: moment().format('HH:mm'),
      status: false,
    },
  },
  getters: {},
  mutations: {
    setTurn(state, turn) {
      state.turn = turn;
    },
  },
  actions: {
    async getTurns(state) {
      const rootState = state.rootState;
      const { itemsPerPage, sortBy, page, sortDesc } = rootState;

      let queryString = '';
      itemsPerPage && (queryString += `&limit=${itemsPerPage}`);
      page && (queryString += `&page=${page}`);
      sortDesc && (queryString += `&ascending=${sortDesc}`);
      sortBy && (queryString += `&orderBy=${sortBy}`);

      try {
        const { data } = await axios.get(
          `${rootState.apiURL}/turns?${queryString}`
        );

        state.commit('setItems', data.data);
        state.commit('setTotalItems', data.count);
      } catch (error) {
        Swal.fire('Error', error.response.data.message, 'error');
      }
    },

    async getTurn(state, id) {
      const rootState = state.rootState;
      try {
        const { data } = await axios.get(`${rootState.apiURL}/turns/${id}`);
        state.commit('setTurn', data.turn);
      } catch (error) {
        Swal.fire('Error', error.response.data.message, 'error');
      }
    },

    async deleteTurn(state, id) {
      const rootState = state.rootState;
      try {
        await axios.delete(`${rootState.apiURL}/turns/${id}`);
        state.dispatch('getTurns');
        Swal.fire(
          'Felicidades',
          'El registro fue eliminado correctamente',
          'success'
        );
      } catch (error) {
        Swal.fire('Error', error.message, 'error');
      }
    },

    async saveTurn(state, { mode, data }) {
      const rootState = state.rootState;
      const { turn, status, id } = data;
      try {
        if (mode === 'create') {
          await axios.post(`${rootState.apiURL}/turns/`, { turn, status });
        } else {
          await axios.put(`${rootState.apiURL}/turns/${id}`, {
            turn,
            status,
          });
        }
        state.dispatch('getTurns');
        Swal.fire(
          'Felicidades',
          'La infroamcion fue actualizada correctamente',
          'success'
        );
        router.push({ name: 'Turns' });
      } catch (error) {
        Swal.fire('Error', error.message, 'error');
      }
    },
  },
};
