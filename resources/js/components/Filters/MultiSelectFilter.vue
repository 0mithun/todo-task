<template>
  <div
    class="multi-select-filter"
    ref="multi_select_filter"
    v-click-away="() => (opened = false)"
  >
    <div class="label">
      <span @click="loadOptions">{{ $t(labelText) }}</span>
      <span class="ml-[10px]" @click="loadOptions">
        <svg
          width="22"
          height="14"
          viewBox="0 0 22 14"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M2.66406 2.6665L10.9974 10.9998L19.3307 2.6665"
            stroke="#063F5F"
            stroke-width="3"
            stroke-linecap="square"
          />
        </svg>
      </span>
    </div>
    <ul class="options" v-show="opened">
      <li class="option" v-for="option in options" :key="option[valueKey]">
        <label>
          <input
            type="checkbox"
            :value="option[valueKey]"
            v-model="selectedItems"
            class="option_checkbox"
          />

          {{ translate ? $t(option[labelKey] ?? "") : option[labelKey] }}
        </label>
      </li>
    </ul>
  </div>
</template>

<script>
import Checkbox from "./Checkbox.vue";
import { debounce as _debounce } from "lodash";
import { trans } from "laravel-vue-i18n";

export default {
  props: {
    label: {
      type: String,
      required: true,
    },
    valueKey: {
      type: String,
      default: "id",
    },
    labelKey: {
      type: String,
      default: "name",
    },
    column: {
      type: String,
      required: true,
    },
    routeName: {
      type: String,
      required: true,
    },
    translate: {
        type: Boolean,
        default: true,
    }
  },
  components: { Checkbox },

  data() {
    return {
      opened: false,
      selectedItems: [],
      options: [],
    };
  },

  computed: {
    labelText() {
      if (this.selectedItems.length && this.options.length) {
        const option = this.options.find(
          (item) => item[this.valueKey] == this.selectedItems[0]
        );
        if (option) {
          const length = this.selectedItems.length;
          const translatedLabel = this.$t(option[this.labelKey] ?? "");
          const text = `${translatedLabel} ${
            length > 1 ? ", +" + String(length - 1) : ""
          }`;

          return text;
        }

        return this.label;
      }

      return this.label;
    },
  },
  watch: {
    selectedItems: {
      handler: _debounce(async function (newValue, oldValue) {
        const query = { ...this.$route.query };
        delete query.page;
        query[this.column] = this.selectedItems.join(",");
        this.$emit("updateResult");

        this.opened = false;
        this.$router.push({ query });
      }, 500),
      deep: true,
    },
  },
  mounted() {
    this.getSelectdOptionsFromUrl();
    this.getOptions();
  },
  methods: {
    async getOptions() {
      try {
        const res = await axios.get(
          route(this.routeName, { ...this.$route.query, column: this.column })
        );
        this.options = res.data;
        // this.opened = true;
      } catch (error) {
        console.log(error);
      }
    },
    loadOptions() {
      if (this.opened) {
        this.opened = false;
      } else {
        this.opened = true;
        // this.getOptions();
      }
    },
    getSelectdOptionsFromUrl() {
      const queries = this.$route.query;
      Object.keys(queries).forEach((key) => {
        if (key == this.column && queries[key]) {
          this.selectedItems = String(queries[key]).split(",");
        }
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.multi-select-filter {
  position: relative;
  display: inline-block;

  .label {
    display: flex;
    gap: 10px;
    align-items: center;

    span {
      font-family: "Poppins";
      font-style: normal;
      font-weight: 400;
      font-size: 16px;
      line-height: 24px;
      color: #4c85a7;
      cursor: pointer;
    }
  }

  .options {
    position: absolute;
    display: flex;
    flex-direction: column;
    list-style: none;
    background-color: white;
    min-width: 268px;
    max-height: 350px;
    overflow: auto;
    left: 0px;
    padding: 0px;
    top: 35px;

    border: 1px solid #fef1e7;
    max-height: 300px;
    overflow-y: auto;

    .option {
      border-top: 1px solid #fef1e7;

      &:first-child {
        border-top: 0;
      }

      width: 100%;

      label {
        font-family: "Poppins";
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;

        color: #4c85a7;
        cursor: pointer;

        display: flex;
        // align-items: center;
        gap: 10px;
        padding: 10px;

        .option_checkbox {
          appearance: none;

          width: 24px;

          &::before {
            content: "";
            width: 24px;
            height: 24px;
            background-color: #ffffff;
            display: block;
            outline: 2px solid #c8c8c8;
            cursor: pointer;
          }
        }

        .option_checkbox:checked {
          &::before {
            // content: '';
            // width: 30px;
            // height: 30px;
            outline: 2px solid #c8c8c8;
            border: 5px solid #ffffff;
            padding: 5px;
            background-color: #9fdcf8;
            display: block;
          }
        }
      }
    }
  }
}
</style>
