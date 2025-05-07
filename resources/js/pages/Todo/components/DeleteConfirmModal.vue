<template>
  <div class="modal-dialog">
    <div class="confirm__modal relative" v-if="showModal">
      <div class="confirm__modal--header">
        <h4>{{ $t("Delete institute") }}</h4>
      </div>
      <div class="confirm__modal--body">
        {{
          $t("Are you sure you want to delete :name?", { name: company.name })
        }}
      </div>
      <div class="confirm__modal--footer">
        <button class="button confirm" @click.prevent="deleteCompany">
          {{ $t("Yes") }}
        </button>
        <button class="button cancel" @click.prevent="$emit('close')">
          {{ $t("No") }}
        </button>
      </div>


        <div class="close-icon absolute right-3 top-3">
            <CloseIcon
                class="cursor-pointer"
                @click.prevent="$emit('close')"
            ></CloseIcon>
        </div>

    </div>
  </div>
</template>

<script>
import axios from "axios";
import { trans } from "laravel-vue-i18n";
import CloseIcon from "@/components/icons/CloseIconLarge.vue";
export default {
  props: {
    company: {
      type: Object,
      required: true,
    },
  },
  components: {
    CloseIcon
  },
  data() {
    return {
      showModal: true,
    };
  },
  mounted() {
    //
  },
  methods: {
    async deleteCompany() {
      try {
        const res = await axios.delete(
          route("companies.destroy", { company: this.company.id })
        );
        const message = trans(
          "The institute :name has been successfully deleted.",
          {
            name: this.company.name,
          }
        );
        this.emitter.emit(`show-success-notification`, message);
        this.$emit("companyDeleted");
        this.$emit("close");
      } catch (error) {
        console.log(error);
        this.emitter.emit("show-error-notification", trans(error));
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.modal-dialog {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 9;
}
.confirm__modal {
  width: 600px;
  background: #ffffff;
  box-shadow: 8px 8px 0px #d3e3ec;
  padding: 24px 32px;
  position: fixed;
  z-index: 9;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  &--header {
    text-align: center;
    margin-bottom: 32px;

    h4 {
      margin: 0;
      padding: 0;

      font-family: "Poppins";
      font-style: normal;
      font-weight: 700;
      font-size: 18px;
      line-height: 27px;

      color: #16a9b7;
    }
  }

  &--body {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 24px;
    text-align: center;
    color: #2c5b7d;
  }

  &--footer {
    margin-top: 32px;
    display: flex;
    justify-content: space-between;

    gap: 32px;
    .button {
      width: 50%;
      padding: 8px;

      /* Poppins Bold / 18 */

      font-family: "Poppins";
      font-style: normal;
      font-weight: 700;
      font-size: 18px;
      line-height: 27px;
      text-align: center;
    }

    .confirm {
      color: #ffffff;
      background: #16a9b7;
    }

    .cancel {
      background: #c6e9f2;
      color: #19849e;
    }
  }
}
</style>
