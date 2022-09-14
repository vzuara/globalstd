<template>
  <v-app class="bgApp">
    <router-view />
  </v-app>
</template>

<script>
export default {
  name: 'App',

  data: () => ({
    //
  }),
};
</script>

<style scoped>
.bgApp {
  background-color: #db5b6c1a;
}
</style>
