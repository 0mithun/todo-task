<template>
  <div class="flex items-center mb-4">
    <h3 class="label">{{ $t(label) }}:</h3>
    <h3 class="value">{{ $t(String(value ?? "")) }}</h3>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: true,
    },
    value: {
      required: true,
    },
  },
};
</script>

<style lang="scss" scoped>
.label {
  color: var(--Primary-Ball-Blue, #16a9b7);
  font-family: Poppins;
  font-size: 15px;
  font-style: normal;
  font-weight: 500;
  line-height: normal;
  margin-right: 3px;
}
.value {
  color: var(--1-4, #2c5b7d);
  font-family: Poppins;
  font-size: 18px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
}
</style>
