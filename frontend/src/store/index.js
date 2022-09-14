import Vue from 'vue';
import Vuex from 'vuex';
import { authModule } from './auth';
import { moviesModule } from './movies';
import { turnsModule } from './turns';
import { assignmentsModule } from './assignments';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    isOpenDrawer: false,
    loading: false,
    apiURL: 'http://localhost:8000/api',
    items: [],
    totalItems: 0,
    itemsPerPage: 10,
    sortBy: null,
    page: 1,
    sortDesc: null,
  },
  mutations: {
    setIsOpenDrawer(state, isOpenDrawer) {
      state.isOpenDrawer = isOpenDrawer;
    },
    setLoading(state, loading) {
      state.loading = loading;
    },
    resetState(state) {
      state.items = [];
      state.totalItems = 0;
      state.itemsPerPage = 10;
      state.sortBy = null;
      state.page = 1;
      state.sortDesc = null;
    },
    setItems(state, items) {
      state.items = items;
    },
    setTotalItems(state, totalItems) {
      state.totalItems = totalItems;
    },
    setPage(state, page) {
      state.page = page;
    },
    setItemsPerPage(state, itemsPerPage) {
      state.itemsPerPage = itemsPerPage;
    },
    setSortBy(state, sortBy) {
      state.sortBy = sortBy[0];
    },
    setSortDesc(state, sortDesc) {
      state.sortDesc = sortDesc[0] ? 1 : 0;
    },
  },
  actions: {},
  modules: {
    authModule,
    moviesModule,
    turnsModule,
    assignmentsModule,
  },
});
