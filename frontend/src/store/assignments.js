import axios from 'axios';

export const assignmentsModule = {
  state: {},
  getters: {},
  mutations: {},
  actions: {
    async saveAssignment(state, { movie_id, turn_ids, itinerary }) {
      try {
        await axios.post(`${state.rootState.apiURL}/assignments/`, {
          movie_id,
          turn_ids,
          itinerary,
        });
        return true;
      } catch (error) {
        alert(error.response.data.message);
      }
    },

    async deleteAssignment(state, { movie_id, turn_id }) {
      try {
        await axios.put(`${state.rootState.apiURL}/assignments/${movie_id}`, {
          turn_id,
        });
        return true;
      } catch (error) {
        alert(error.response.data.message);
      }
    },
  },
};
