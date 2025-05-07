<template>
  <div class="table-row tr">
    <div class="td" style="width: 10%">
      <img :src="data.logo_url" style="width: 40px; height: 40px" />
    </div>
    <div class="td" style="width: 25%">
      {{ data.name }}
    </div>
    <div class="td" style="width: 30%">
      {{ data.email }}
    </div>
    <div class="td" style="width: 15%">
      {{ displayModules }}
    </div>
    <div class="td" style="width: 10%">
      <Status :company="data" :key="componentKey" />
    </div>
    <div class="td" style="width: 10%">
      <MenuBar
        :key="componentKey"
        :company="data"
        @companyDeleted="companyDeleted"
      />
    </div>
  </div>
</template>

<script >
import MenuBar from "./MenuBar.vue";
// import statusBadeg from "@/components/status/StatusBadge.vue";
import { trans } from "laravel-vue-i18n";
import { useUserStore } from "@/store/user.js";
import { storeToRefs } from "pinia";
import Status from "./Status.vue";
export default {
  components: {
    MenuBar,
    Status,
  },
  props: {
    company: {
      type: Object,
      requied: true,
    },
  },
  data() {
    return {
      data: this.company,
      componentKey: 0,
    };
  },
  computed: {
    displayModules() {
      const modules = [];
      if (this.data.playgroup) modules.push(trans("playgroup"));
      if (this.data.daycare) modules.push(trans("Daycare"));
      return modules.sort().join(", ");
    },
  },
  mounted() {
    this.emitter.on(`update-status-${this.data.id}`, (status) => {
      this.data.status = status;
      this.componentKey++;
    });
  },
  methods: {
    companyDeleted() {
      this.$emit("companyDeleted");
    },
  },
};
</script>

<style lang="scss" scoped>
// @import "@css/_mixins.scss";

// .td {
//   @include respond(big-desktop) {
//     font-size: 12px;
//   }
//   @include respond(desktop) {
//     font-size: 12px;
//   }

//   @include respond(laptop) {
//     font-size: 10px;
//   }
//   @include respond(tab-land) {
//     font-size: 10px;
//   }
// }
.table-row.tr {
  padding: 0 20px 0 15px !important;
}
.td {
  word-break: break-word;
  overflow-wrap: break-word;
  text-align: left;
  vertical-align: middle;
  white-space: normal;
}
</style>
