<template>
  <div class="d-flex align-center">
    <v-img
      alt="EasyGoBand logo"
      class="logo shrink mr-2 hidden-md-and-up"
      contain
      src="./../../assets/logo.png"
      transition="scale-transition"
      width="100"
    />

    <v-img
      alt="EasyGoBand logo"
      class="logo shrink mt-1 hidden-sm-and-down"
      contain
      min-width="200"
      src="./../../assets/logo.png"
      width="200"
    />
  </div>
</template>

<script>
export default {
  name: 'Logo',
};
</script>
