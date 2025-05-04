<template>
  <img :src="image" alt="image" />
</template>

<script setup>
const props = defineProps({
  image: {
    type: String,
    required: false,
  },

});
</script>

<style lang="scss" scoped>
img {
  width: 40px;
  height: 40px;
//   border-radius: 40px;
}
</style>
