<template>
  <v-btn color="pink" dark icon @click.stop="setIsOpenDrawer(true)">
    <v-icon>mdi-menu</v-icon>
  </v-btn>
</template>

<script>
import { mapMutations } from 'vuex';

export default {
  name: 'DrawerBtn',
  methods: {
    ...mapMutations(['setIsOpenDrawer']),
  },
};
</script>

<style></style>
