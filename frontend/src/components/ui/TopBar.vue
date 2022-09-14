<template>
  <v-app-bar app color="white" elevation="0">
    <DrawerBtn class="hidden-md-and-up" />
    <v-toolbar elevation="0">
      <v-spacer class="hidden-sm-and-up"></v-spacer>
      <Logo />
      <v-spacer></v-spacer>
      <AvatarName />
    </v-toolbar>
  </v-app-bar>
</template>

<script>
import Logo from './Logo.vue';
import AvatarName from './AvatarName.vue';
import DrawerBtn from './DrawerBtn.vue';

export default {
  name: 'TopBar',
  components: {
    Logo,
    AvatarName,
    DrawerBtn,
  },
};
</script>
