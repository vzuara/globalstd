<template>
  <v-container fluid fill-height>
    <v-layout d-flex align-center justify-center>
      <router-view></router-view>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'PublicLayout',
};
</script>
