<template>
  <div class="flex flex-col multi-select wrapper" :class="$attrs.class">
    <h2 class="input-label" :class="$attrs.labelClass" v-if="$attrs.label">
      {{ $t($attrs.label ?? "") }}
        <span class="text-danger">
          {{ $attrs.asterisk ? "*" : "" }}
        </span>
    </h2>

    <div class="relative wrapper" v-click-away="() => (expanded = false)">
      <div
        class="toggler flex items-center justify-start rounded-[4px] min-h-[46px]"
        :class="[
          expanded ? 'rounded-b-[0px]' : '',
          error ? '!border-[#DC3545]' : '',
          $attrs.togglerClass,
        ]"
        @click="toggle"
      >
        <slot name="placeholder">
          <template v-if="selectedOptions.length">
            <div class="flex flex-wrap gap-1 selected-items">
              <template
                v-for="(
                  { [labelKey]: label, [valueKey]: value, ...rest }, index
                ) in selectedOptions"
                :key="index"
              >
                <slot
                  name="placeholder-item"
                  :item="{ label, value, rest }"
                  :toggleSelectedItems="toggleSelectedItems"
                >
                  <div
                    class="flex items-center gap-1 p-2 bg-gray-100 rounded-lg item"
                  >
                    <span class="font-poppins text-[12px] text-[#343434]">
                      {{ label }}
                    </span>
                    <CloseSmallIcon
                      v-if="!disabled"
                      class="text-gray-400 hover:text-gray-500"
                      @click.stop="toggleSelectedItems(value)"
                    />
                  </div>
                </slot>
              </template>
            </div>
          </template>
          <template v-else>
            <p
              class="placeholder !text-[#919FA1]"
              v-trans="$attrs.placeholder"
              :class="$attrs.placeholderClass"
            ></p>
          </template>
        </slot>
        <div class="ml-auto toggle-icon">
          <ToggleUpIcon v-if="expanded && !disabled" />
          <ToggleDownIcon v-else />
        </div>
      </div>

      <div
        class="options absolute z-[1] bg-white flex flex-col w-full rounded-b-lg border border-input border-t-0 max-h-[150px] overflow-y-auto"
        :class="$attrs.optionsClass"
        v-if="expanded && !disabled"
        @scroll="scrollCheck"
        ref="scroll"
      >
        <template v-if="searchable">
            <slot name="search">
                <input
                    autofocus
                    class="search__input"
                    v-model="search"
                    @blur="search = null"
                />
            </slot>
        </template>

        <template
          v-for="(
            { [labelKey]: label, [valueKey]: value, ...rest }, index
          ) in selectableOptions"
          :key="index"
        >
          <slot
            name="option"
            :option="{ label, value, rest }"
            :toggle="toggleSelectedItems"
          >
            <div
              class="option px-3 py-[5px] flex gap-[10px] items-center cursor-pointer hover:bg-[#dfdfdf] w-full"
              :class="$attrs.optionClass"
              @click="toggleSelectedItems(value)"
            >
              <span v-if="!$attrs.translate">{{ label }}</span>
              <span :class="$attrs.optionTextClass" v-else>
                {{ $t(label ?? "") }}
              </span>
            </div>
          </slot>
        </template>
      </div>

      <p
        class="text-[#dc3545] text-[13px] mt-[3px]"
        v-if="typeof error == 'string' && error"
      >
        {{ error }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "@vue/reactivity";
import { computed, useAttrs, watch } from "vue";
import { debounce } from "lodash";

import ToggleDownIcon from "@/components/icons/ToggleDown.vue";
import ToggleUpIcon from "@/components/icons/ToggleUp.vue";
import CloseSmallIcon from "@/components/icons/CloseSmallIcon.vue";

const attrs = useAttrs();
const emit = defineEmits([
  "update:modelValue",
  "opened",
  "scrolled",
  "search",
  "change",
]);
const expanded = ref(false);

const props = defineProps({
  options: {
    type: Array,
    requried: true,
  },
  valueKey: {
    type: String,
    default: "value",
  },
  labelKey: {
    type: String,
    default: "label",
  },
  error: {
    type: [Boolean, String],
    requried: false,
  },

  searchable: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
});

const search = ref("");
const search_input = ref();

const selectableOptions = computed(() => {
  return props.options.filter(
    (i) => !attrs.modelValue.includes(i[props.valueKey])
  );
});

const selectedOptions = computed(() => {
  return props.options.filter((i) =>
    attrs.modelValue.includes(i[props.valueKey])
  );
});

const toggle = () => {
  expanded.value = !expanded.value;
  setTimeout(() => search_input.value?.focus(), 0);
  if (expanded.value) emit("opened");
};

const toggleSelectedItems = (value) => {
  let selected_items = [];

  selected_items = attrs.modelValue.includes(value)
    ? attrs.modelValue.filter((item) => item !== value)
    : [...attrs.modelValue, value];
  emit("update:modelValue", selected_items);
  emit("change");
};

const scroll = ref(null);
const scrollCheck = debounce(() => {
  const el = scroll.value;
  const { scrollTop, scrollHeight, clientHeight } = el;

  if (scrollTop + clientHeight >= scrollHeight - 100) {
    emit("scrolled");
  }
}, 200);

watch(
  () => search.value,
  // debounce((val) => console.log(val), 100),
  debounce((val) => emit("search", val), 100)
);
</script>

<script>
export default {
  inheritAttrs: false,
};
</script>

<style lang="scss" scoped>
.placeholder {
  color: #343434;
  font-family: Poppins;
  font-size: 13px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
}

.toggler {
  border: 1px solid #dee2e6;
  background: #fff;
  cursor: pointer;
  padding: 10px 15px;
}
.option {
  color: #343434;
  font-family: Poppins;
  font-size: 13px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
  word-break: break-all;
}

.search__input {
  @apply px-4 py-3 outline-none hover:outline-none focus:outline-none placeholder:text-[#525F7F] w-full;
  padding-left: 35px;
  height: 46px;
  border-bottom: 1px solid #dee2e6;
  color: #000000;

  background-image: url("data:image/svg+xml,%3Csvg width='19' height='19' viewBox='0 0 19 19' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M18.6937 17.4023L12.607 11.3156C13.5516 10.0945 14.0625 8.60156 14.0625 7.03125C14.0625 5.15156 13.3289 3.38906 12.0023 2.06016C10.6758 0.73125 8.90859 0 7.03125 0C5.15391 0 3.38672 0.733594 2.06016 2.06016C0.73125 3.38672 0 5.15156 0 7.03125C0 8.90859 0.733594 10.6758 2.06016 12.0023C3.38672 13.3312 5.15156 14.0625 7.03125 14.0625C8.60156 14.0625 10.0922 13.5516 11.3133 12.6094L17.4 18.6937C17.4178 18.7116 17.439 18.7258 17.4624 18.7354C17.4857 18.7451 17.5107 18.7501 17.5359 18.7501C17.5612 18.7501 17.5862 18.7451 17.6095 18.7354C17.6328 18.7258 17.654 18.7116 17.6719 18.6937L18.6937 17.6742C18.7116 17.6564 18.7258 17.6352 18.7354 17.6119C18.7451 17.5885 18.7501 17.5635 18.7501 17.5383C18.7501 17.513 18.7451 17.488 18.7354 17.4647C18.7258 17.4414 18.7116 17.4202 18.6937 17.4023ZM10.7438 10.7438C9.75 11.7352 8.43281 12.2812 7.03125 12.2812C5.62969 12.2812 4.3125 11.7352 3.31875 10.7438C2.32734 9.75 1.78125 8.43281 1.78125 7.03125C1.78125 5.62969 2.32734 4.31016 3.31875 3.31875C4.3125 2.32734 5.62969 1.78125 7.03125 1.78125C8.43281 1.78125 9.75234 2.325 10.7438 3.31875C11.7352 4.3125 12.2812 5.62969 12.2812 7.03125C12.2812 8.43281 11.7352 9.75234 10.7438 10.7438Z' fill='%23ADB5BD'/%3E%3C/svg%3E%0A");
  background-repeat: no-repeat no-repeat;
  background-position: 10px center;
}
</style>
