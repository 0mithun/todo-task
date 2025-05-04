<template>
  <div class="input-element w-full" :class="$attrs.wrapperClass">
    <label
      :for="$attrs.id"
      class="form-label"
      :class="$attrs.labelClass"
      v-if="label"
    >
      <template v-if="typeof $attrs.label == 'object'">
        {{ $t(label.text, label.replace) }}
      </template>
      <template v-else>
        {{ $t(label) }}{{ $attrs.asterisk ? "*" : "" }}
      </template>
    </label>
    <div :class="{ 'border-error': error || serverError }">
      <textarea
        class="w-full text-input min-h-[200px]"
        :class="{ 'border-error': error }"
        v-bind="$attrs"
        :placeholder="
          typeof $attrs.placeholder == 'object'
            ? $t($attrs.placeholder.text, $attrs.placeholder.replace)
            : $t($attrs.placeholder ?? '')
        "
        :value="$attrs.modelValue"
        @input="updateInput"
        ref="textarea"
      ></textarea>
    </div>
    <p
      class="error-box flex p-0 items-center gap-2 mt-[4px] text-error text-12"
      v-if="typeof error == 'string' && error && showError"
    >
      {{ $t(error) }}
      <!-- <ErrorCrossIcon /> {{ $t(error) }} -->
    </p>
  </div>
</template>

<script setup>
// import ErrorCrossIcon from '@/components/icons/ErrorCross.vue'
import { ref } from "vue";
defineProps({
  label: {
    type: [String, Object],
    required: false,
    default: "",
  },
  error: {
    type: [Boolean, String],
    required: false,
  },
  serverError: {
    type: [Boolean, String],
    required: false,
  },
  showError: {
    type: Boolean,
    default: true,
  },
});
const emit = defineEmits(["update:modelValue"]);

const textarea = ref(null);
const updateInput = (e) => {
  textarea.value.style.height = textarea.value.scrollHeight + "px";
  emit("update:modelValue", e.target.value);
};
</script>

<script>
export default {
  inheritAttrs: false,
};
</script>

<style lang="scss" scoped>
.form-label {
  color: var(--Primary-Ball-Blue, #16a9b7);
  font-family: Poppins;
  font-size: 18px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;

  margin-bottom: 12px;
  display: inline-block;
}

.text-input {
  background: #fff;
  border: none;
  outline: none;
  color: #063f5f;
  font-family: Poppins;
  font-size: 15px;
  font-style: normal;
  font-weight: 500;
  line-height: normal;
  border-radius: 4px;

  height: 40px;
  padding: 14px 24px;

  &:focus {
    outline: none;
    border: none;
  }

  &::placeholder {
    color: var(--1-2, #87b1cb);
    font-family: Nexa;
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
  }
}

.text-error {
  color: #e97d32;
}

p.text-error {
    color: #e97d32;
}
</style>
