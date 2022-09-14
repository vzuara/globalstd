<template>
  <v-main>
    <TopBar />

    <v-container
      fluid
      style="height: 100%"
      class="align-start pa-0 d-flex flex-row"
    >
      <Drawer />
      <v-container fluid>
        <v-row>
          <v-col>
            <router-view></router-view>
          </v-col>
        </v-row>
      </v-container>
    </v-container>
  </v-main>
</template>

<script>
import TopBar from './../ui/TopBar.vue';
import Drawer from './../ui/Drawer.vue';

export default {
  name: 'PrivateLayout',
  components: { TopBar, Drawer },
  data: () => ({
    drawer: null,
    items: [
      { title: 'Home', icon: 'mdi-view-dashboard' },
      { title: 'About', icon: 'mdi-forum' },
    ],
  }),
};
</script>
