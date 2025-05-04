<template>
  <div class="">
    <h3 class="label mb-4">{{ $t(label) }}</h3>
    <h3 class="value">
        <template v-if="translate">
            {{ $t(String(value ?? "")) }}
        </template>
        <template v-else>
            {{ value?? '' }}
        </template>
        <!-- {{ translate ? $t(String(value ?? "")) : String(value ?? "") }} -->
    </h3>
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
    translate: {
        type: Boolean,
        default: true
    }
  },
};
</script>

<style lang="scss" scoped>
.label {
  color: var(--Primary-Ball-Blue, #16a9b7);
  font-family: Poppins;
  font-size: 18px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
}
.value {
  color: var(--1-4, #2c5b7d);
  font-family: Poppins;
  font-size: 15px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
}
</style>
