<template>
  <div class="nationality__select" v-click-away="() => (dropdownOpen = false)">
    <div class="label mb-3">
      {{ $t(label) }}{{ $attrs.asterisk ? "*" : "" }}
    </div>
    <div
      class="flex items-center justify-between body bg-white"
      :class="{
        'rounded-b-none': dropdownOpen,
        'border-error': error || serverError,
      }"
    >
      <div class="placeholder flex w-full">
        <!-- <input class="country__selector" type="text"> -->
        <div class="country__selector" @click="toggleDropdown">
          <div
            class="flag iti-flag"
            :style="{ backgroundImage: `url(${FlagImage})` }"
            :class="selected_country?.value"
          ></div>
          <div class="dial_code">+{{ selected_country.dialCode }}</div>
          <div class="cursor-pointer" @click.stop="toggleDropdown">
            <ToggleDownIcon v-if="!dropdownOpen" />
            <ToggleUpIcon v-else />
          </div>
        </div>
        <div class="custom-border-left"></div>
        <input
          class="phone__number__input"
          type="text"
          v-model="number"
          :placeholder="$attrs.number_placeholder ?? ''"
        />
        <!-- <label class="cursor-pointer" :class="placeholder == placeholderText ? 'text-[#919FA1]' : ''" >{{ placeholderText }}</label> -->
      </div>
    </div>
    <p class="text-error" v-if="errorMessage && showError">
      {{ $t(errorMessage) }}
    </p>
    <div class="dropdown" v-if="dropdownOpen">
      <div>
        <div class="dropdown-item-search">
          <input class="search__input" ref="searchInput" v-model="search" />
        </div>
      </div>
      <ul class="dropdown-options" ref="selectDropdown">
        <li
          class="flex items-center gap-3 dropdown-item"
          :id="`country-${country.value.toLowerCase()}`"
          :class="{
            active:
              selected_country?.value?.toLowerCase() ==
              country.value.toLowerCase(),
          }"
          @click="selectItem(country.value)"
          v-for="country in countries"
          :key="country.value"
        >
          <div
            class="default-flat iti-flag"
            :style="{ backgroundImage: `url(${FlagImage})` }"
            :class="`${country.value.toLowerCase()}`"
          ></div>

          <span> +{{ country.dialCode }} </span>
          <span class="ml-auto">
            {{ country.label }}
          </span>
        </li>
      </ul>
    </div>
  </div>
</template>

  <script>
import ToggleDownIcon from "@/components/icons/ToggleDown.vue";
import ToggleUpIcon from "@/components/icons/ToggleUp.vue";
import countriesLists from "@/countries.json";
import { computed, ref } from "vue";
import { trans } from "laravel-vue-i18n";

import FlagImage from "@image/flags.png";

import { useGetCountryName } from "@/composables/translation.js";
import { useAttrs } from "vue";

export default {
  components: {
    ToggleUpIcon,
    ToggleDownIcon,
  },
  props: {
    modelValue: {
      type: String,
      required: false,
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: null,
    },
    error: {
      type: [Boolean, String],
      required: false,
    },
    serverError: {
      type: [Boolean, String],
      required: false,
    },
    locale: {
      type: String,
      default: null,
    },
    showError: {
      type: Boolean,
      default: true,
    },
  },
  setup(props, { emit }) {
    const dropdownOpen = ref(false);
    const searchInput = ref(null);
    const search = ref("");
    const selectDropdown = ref(null);

    const attrs = useAttrs();

    const selected_country = computed({
      get: () =>
        translateCountries.value?.find(
          (country) =>
            country.value == (attrs.country_code?.toLowerCase() || "ch")
        ),
      set: (value) => {
        emit("update:country_code", value);
        emit("updated", value);
      },
    });

    const number = computed({
      get: function () {
        return attrs.phone_number;
      },
      set: function (value) {
        emit("update:phone_number", value);
        emit("updated", value);
      },
    });

    const placeholderText = computed(() => {
      if (props.modelValue) {
        return useGetCountryName(props.modelValue, props.locale);
      }
      return props.placeholder
        ? trans(props.placeholder)
        : trans("Select Nationality");
    });

    const translateCountries = computed(() => {
      return countriesLists.map((country) => ({
        value: country.iso,
        label: useGetCountryName(country.iso, props.locale),
        dialCode: country.dialCode,
      }));
    });

    const countries = computed(() => {
      return translateCountries.value.filter((item) => {
        if (item.label) {
          return item.label.toLowerCase().includes(search.value.toLowerCase());
        }
      });
    });

    const errorMessage = computed(() => {
      if (typeof props.error == "string" && props.error) {
        return props.error;
      } else if (typeof props.serverError == "string" && props.serverError) {
        return props.serverError;
      }
      return null;
    });

    const selectItem = (value) => {
      // emit("update:modelValue", value);
      emit("update:country_code", value);
      emit("updated", value);
      search.value = "";
      dropdownOpen.value = false;
    };

    const toggleDropdown = () => {
      setTimeout(() => {
        searchInput.value.focus();
        const country = countries.value.find(
          (item) =>
            item.value.toLowerCase() == attrs.country_code?.toLowerCase()
        );

        if (country) {
          const item = document.getElementById(
            `country-${attrs.country_code?.toLowerCase()}`
          );
          selectDropdown.value.scrollTop = item.offsetTop - 110;
        }
      }, 100);

      dropdownOpen.value = dropdownOpen.value == true ? false : true;
    };

    return {
      dropdownOpen,
      toggleDropdown,
      searchInput,
      search,
      countries,
      selectItem,
      selectDropdown,
      placeholderText,
      FlagImage,
      errorMessage,
      selected_country,
      number,
    };
  },
};
</script>

<style lang="scss" scoped>
.nationality__select {
  position: relative;

  .label {
    color: var(--Primary-Ball-Blue, #16a9b7);
    font-family: Poppins;
    font-size: 18px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
  }

  .body {
    // border-radius: 6px;
    border: 1px solid #e9f7fe;
    color: #063f5f;
    font-family: Poppins;
    font-size: 15px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    height: 42px;
    padding: 12px;
  }

  .dropdown {
    background: #ffffff;
    width: 100%;
    position: absolute;
    z-index: 999;

    .dropdown-options {
      max-height: 250px;
      overflow-y: auto;
      color: #4d5a5c;
      padding: 4px;
    }
    .search__input {
      @apply p-3 outline-none hover:outline-none focus:outline-none placeholder:text-[#525F7F] w-full;
      padding-left: 35px;
      height: 46px;
      border-bottom: 1px solid #dee2e6;
      color: #111111;
      font-size: 14px;
      background-image: url("data:image/svg+xml,%3Csvg width='19' height='19' viewBox='0 0 19 19' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M18.6937 17.4023L12.607 11.3156C13.5516 10.0945 14.0625 8.60156 14.0625 7.03125C14.0625 5.15156 13.3289 3.38906 12.0023 2.06016C10.6758 0.73125 8.90859 0 7.03125 0C5.15391 0 3.38672 0.733594 2.06016 2.06016C0.73125 3.38672 0 5.15156 0 7.03125C0 8.90859 0.733594 10.6758 2.06016 12.0023C3.38672 13.3312 5.15156 14.0625 7.03125 14.0625C8.60156 14.0625 10.0922 13.5516 11.3133 12.6094L17.4 18.6937C17.4178 18.7116 17.439 18.7258 17.4624 18.7354C17.4857 18.7451 17.5107 18.7501 17.5359 18.7501C17.5612 18.7501 17.5862 18.7451 17.6095 18.7354C17.6328 18.7258 17.654 18.7116 17.6719 18.6937L18.6937 17.6742C18.7116 17.6564 18.7258 17.6352 18.7354 17.6119C18.7451 17.5885 18.7501 17.5635 18.7501 17.5383C18.7501 17.513 18.7451 17.488 18.7354 17.4647C18.7258 17.4414 18.7116 17.4202 18.6937 17.4023ZM10.7438 10.7438C9.75 11.7352 8.43281 12.2812 7.03125 12.2812C5.62969 12.2812 4.3125 11.7352 3.31875 10.7438C2.32734 9.75 1.78125 8.43281 1.78125 7.03125C1.78125 5.62969 2.32734 4.31016 3.31875 3.31875C4.3125 2.32734 5.62969 1.78125 7.03125 1.78125C8.43281 1.78125 9.75234 2.325 10.7438 3.31875C11.7352 4.3125 12.2812 5.62969 12.2812 7.03125C12.2812 8.43281 11.7352 9.75234 10.7438 10.7438Z' fill='%23ADB5BD'/%3E%3C/svg%3E%0A");
      background-repeat: no-repeat no-repeat;
      background-position: 10px center;
    }

    border-radius: 0px 0px 6px 6px;
    border: 1px solid #dee2e6;
    border-top: none;

    .dropdown-item {
      padding: 4px 12px;
      width: 100%;
      font-size: 15px;
      cursor: pointer;

      &:hover {
        background: #e97d32;
        color: white;
      }
    }

    .dropdown-item.active {
      background: #e97d32;
      color: white;
      // border-radius: 4px;
    }
  }
  .border-error {
    border: 1px solid #e97d32;
  }
  .text-error {
    margin-top: 6px;
    color: #e97d32;
    font-size: 16px;
  }
}

.country__selector {
  display: flex;
  align-items: center;
  overflow: hidden;
  cursor: pointer;
  gap: 10px;
  width: 100px;

  .flag {
    //
  }
}
.phone__number__input {
  height: 40px;
  border: none;
  outline: none;
  // border-left: 1px solid #dee2e6;
  display: block;
  padding-left: 5px;
  color: var(--1-4, #2c5b7d);
  font-family: Nexa;
  font-size: 15px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;

  &::placeholder {
    color: var(--1-2, #87b1cb);
    font-family: Nexa;
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
  }

  width: 340px;
  &:focus {
    outline: none;
    border: none;
  }
}
.custom-border-left {
  width: 1px;
  height: 22px;
  background-color: #dee2e6;
  margin-left: 5px;
  margin-right: 20px;
  align-self: center;
}
</style>
