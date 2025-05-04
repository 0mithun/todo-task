<template>
  <router-link v-if="link" :to="{ name: routeName, ...params }" :class="{'disabled-link': active}">
    <div class="tab px-4 py-2 tab-link" :class="{ active }">
      <slot></slot>
    </div>
  </router-link>
  <div
    v-else
    @click="$emit('change', value)"
    class="tab tab px-4 py-2"
    :class="{ active, disabled }"
  >
    <a class="tab-link">
      <slot></slot>
    </a>
  </div>
</template>

<script setup>
defineProps({
  routeName: {
    type: String,
    default: null,
  },
  link: {
    type: Boolean,
    default: true,
  },
  active: {
    type: Boolean,
    default: false,
  },
  value: {
    type: String,
    default: null,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  params: {
    type: Object,
    default: {}
  }
});
</script>

<style lang="scss" scoped>
.tab {
  // min-width: 200px;
  color: var(--Nutral-Gray-800, #232c2f);
  font-family: Poppins;
  font-size: 14px;
  font-style: normal;
  font-weight: 400;
  line-height: 120%;
  cursor: pointer;
  background: transparent;
  .tab-link {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    width: auto;
  }
}

.tab.active {
    @apply font-semibold border-b-2;
  background: transparent;
  pointer-events: none;
  z-index: 1;
  margin-bottom: -1px;
  border-bottom: 5px solid #063F5F;
}

.tab.disabled {
  cursor: not-allowed;
  pointer-events: none;
}

.disabled-link {
    pointer-events: none;
}
</style>
