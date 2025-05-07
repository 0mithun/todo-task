<template>
  <div class="status-wrapper">
    <div class="status">
      {{ $t(statusText) }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    company: {
      type: Object,
      required: true,
    },
  },
  computed: {
    statusText() {
      if (this.company.status === "active") {
        return "active";
      } else if (this.company.status === "inactive") {
        return "inactive";
      } else {
        return "unknown";
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.status-wrapper {
  display: inline-block;
}

.status {
  padding: 5px 10px;
  background-color: #f0f0f0;
  border-radius: 4px;
}
</style>
