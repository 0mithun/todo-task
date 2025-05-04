<template>
  <div :class="$attrs.class">
    <h2
      class="block mb-3 text-input text-formLabel"
      v-if="label"
      :class="labelClass"
    >
      {{ $t(label) }}
    </h2>
    <div
      class="flex items-center gap-2.5 max-w-fit cursor-pointer"
      @click="toggle"
    >
      <template v-if="modelValue">
        <svg
          width="14"
          height="14"
          viewBox="0 0 14 14"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <rect
            width="14"
            height="14"
            transform="matrix(1 0 0 -1 0 14)"
            fill="#063F5F"
          />
        </svg>
      </template>
      <template v-else>
        <svg
          width="14"
          height="14"
          viewBox="0 0 14 14"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <rect
            x="0.75"
            y="0.75"
            width="12.5"
            height="12.5"
            stroke="#B7C4CB"
            stroke-width="1.5"
          />
        </svg>
      </template>
      <p class="checkLabel" :class="checkLabelClass">
        {{ $t(checkLabel) }}
      </p>
    </div>
    <p
      class="error-box flex p-0 items-center gap-2 mt-[4px] text-error text-12"
      v-if="typeof error == 'string' && error && showError"
    >
      {{ $t(error) }}
    </p>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: Boolean,
      required: true,
      default: true,
    },
    label: {
      type: String,
      default: null,
    },
    checkLabel: {
      type: String,
      required: true,
    },
    labelClass: {
      type: String,
      default: "",
    },
    checkLabelClass: {
      type: String,
      default: "",
    },
    readOnly: {
      type: Boolean,
      default: false,
    },
    showError: {
      type: Boolean,
      default: true,
    },
    error: {
      type: [Boolean, String],
      required: false,
    },
  },
  methods: {
    toggle() {
      if (this.readOnly) return;
      this.$emit("update:modelValue", !this.modelValue);
      this.$emit("input", !this.modelValue);
    },
  },
};
</script>

<style lang="scss" scoped>
.checkLabel {
  color: #16a9b7;
  font-family: Nexa;
  font-size: 18px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
}
.text-error {
  margin-top: 5px;
  color: #e97d32;
  font-size: 16px;
}
</style>
