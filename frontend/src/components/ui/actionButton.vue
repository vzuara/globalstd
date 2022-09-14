<template>
  <v-tooltip bottom>
    <template #activator="{ on }">
      <v-btn
        elevation="0"
        @click="$emit('action')"
        dark
        icon
        small
        v-on="on"
        :color="color"
      >
        <v-icon dark class="mr-2"> {{ icon }} </v-icon>
      </v-btn>
    </template>
    <span>{{ tooltip }}</span>
  </v-tooltip>
</template>

<script>
export default {
  name: 'ActionButton',
  props: {
    icon: {
      required: true,
      type: String,
    },
    color: {
      required: true,
      type: String,
    },
    tooltip: {
      required: true,
      type: String,
    },
  },
};
</script>

<style></style>
