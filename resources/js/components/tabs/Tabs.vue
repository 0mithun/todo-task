<template>
  <div class="tabs">
    <slot></slot>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.tabs {
  @apply flex w-full gap-2 mb-5;
}
</style>
