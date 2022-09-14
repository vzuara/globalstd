<template>
  <div>
    <v-avatar dark color="primary" size="44">
      <span class="white--text">{{ getInitials }}</span>
    </v-avatar>
    <span class="hidden-sm-and-down ml-1">{{ getName }}</span>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
  name: 'AvatarName',
  computed: {
    ...mapGetters(['getName', 'getInitials']),
  },
};
</script>
