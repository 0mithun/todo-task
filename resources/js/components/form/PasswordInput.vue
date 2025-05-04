<template>
  <div class="wrapper">
    <div class="input-element w-full">
      <label
        :for="$attrs.id"
        class="form-label"
        :class="$attrs.labelClass"
        v-if="label"
        >{{ $t(label) }} {{ $attrs.asterisk ? "*" : "" }}
      </label>
    </div>
    <div
      class="password-input toggleable relative"
      :class="{ 'border-error': error }"
    >
      <input
        :id="id"
        class="w-full text-input"
        :class="[{ 'border-error': error }, $attrs.inputClass]"
        v-bind="$attrs"
        :value="$attrs.modelValue"
        :placeholder="placeholder"
        @input="$emit('update:modelValue', $event.target.value)"
        :type="type"
      />

      <div
        v-show="toggleable"
        class="absolute top-[50%] right-[3%] translate-y-[-50%] cursor-pointer"
        @click="type == 'password' ? (type = 'text') : (type = 'password')"
      >
        <eye-close v-show="type != 'password'" />
        <eye-open v-show="type == 'password'" />
      </div>
    </div>
    <p
      class="error-box flex p-0 items-center gap-2 mt-[4px] font-normal font-inter text-error text-[16px]"
      v-if="typeof error == 'string' && error && showError"
    >
      {{ $t(error) }}
    </p>
  </div>
</template>

<script setup>
import EyeClose from "../icons/EyeClose.vue";
import EyeOpen from "../icons/EyeOpen.vue";

const props = defineProps({
  label: {
    type: String,
    requried: false,
  },
  id: {
    type: String,
    required: false,
  },
  type: {
    type: String,
    default: 'password'
  },
  placeholder: {
    type: String,
    required: true,
  },
  toggleable: {
    type: Boolean,
    default: true,
  },
  error: {
    type: [String, Boolean],
    required: false,
  },
  show_previous: {
    type: Boolean,
    default: true,
  },
  showError: {
    type: Boolean,
    default: true,
  },
});
</script>

<script>
export default {
  inheritAttrs: false,
  // components: { PasswordTooltip }
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
  color: var(--1-4, #2c5b7d);
  font-family: Nexa;
  font-size: 15px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;

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

.border-error {
  border: 1px solid #e97d32;
}

.text-error {
  color: #e97d32;
}
</style>
