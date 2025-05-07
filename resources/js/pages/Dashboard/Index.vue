<template>
  <div class="content">
    Welcome to Dashboard
  </div>
</template>

<script setup>

import { onMounted, watch } from '@vue/runtime-core'
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'
import { useUserStore } from '@/store/user'

</script>

<style lang="scss" scoped></style>
