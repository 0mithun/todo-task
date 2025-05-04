<template>
  <div class="auth-layout">
    <div class="left-container">
      <img src="images/login.png" alt="login" />
    </div>
    <div class="right-container">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";

</script>

