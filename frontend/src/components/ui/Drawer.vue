<template>
  <v-navigation-drawer
    :absolute="$vuetify.breakpoint.mobile"
    v-model="drawer"
    :permanent="$vuetify.breakpoint.desktop"
  >
    <v-list>
      <v-list-item
        exact
        v-for="item in items"
        :key="item.title"
        link
        :to="item.to"
      >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import { mapState, mapMutations } from 'vuex';
export default {
  name: 'Drawer',
  data: () => ({
    items: [
      {
        title: 'Dashboard',
        icon: 'mdi-view-dashboard',
        to: '/admin/',
      },
      {
        title: 'Películas',
        icon: 'mdi-filmstrip',
        to: '/admin/movies',
      },
      {
        title: 'Turnos',
        icon: 'mdi-clipboard-text-clock-outline',
        to: '/admin/turns',
      },
      {
        title: 'Administradores',
        icon: 'mdi-account-group',
        to: '#',
      },
      {
        title: 'Perfil',
        icon: 'mdi-account',
        to: '#',
      },
      {
        title: 'Cerrar sesión',
        icon: 'mdi-logout',
        to: '/admin/logout',
      },
    ],
  }),

  methods: {
    ...mapMutations(['setIsOpenDrawer']),
  },
  computed: {
    ...mapState(['isOpenDrawer']),
    drawer: {
      get() {
        if (this.$vuetify.breakpoint.mdAndUp) {
          return true;
        }
        return this.isOpenDrawer;
      },
      set(value) {
        this.setIsOpenDrawer(value);
      },
    },
  },
};
</script>

<style></style>
