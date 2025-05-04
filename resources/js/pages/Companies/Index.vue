<template>
  <div class="px-8 py-6 content">
    <h3 class="overview__title">{{ $t("Institutes") }}</h3>
    <OverviewTable
      :search_enabled="true"
      :footer_enabled="false"
      :paginationData="paginationData"
      class="!border-t-0"
      bodyClass=""
      headerClass=""
      headerTopClass="!py-0 !border-t-0"
      placeholder="Search by institute name"
    >
      <template #filter>
        <Filter filterClass="w-[90%]">
          <MultiSelectFilter
            column="module"
            label="Module"
            routeName="companies.get-filter-dropdown-data"
            valueKey="value"
            labelKey="label"
            style="width: 30%"

          />
          <MultiSelectFilter
            column="status"
            label="Status"
            routeName="companies.get-filter-dropdown-data"
            valueKey="value"
            labelKey="label"
            style="width: 30%"
          />
        </Filter>
      </template>

      <template #overview-top-right>
        <AddNewButton label="Add new institute" routeName="companies.create" />
      </template>

      <template #header>
        <SortTableColumn
          label="Picture"
          columnName="picture"
          :enable="false"
          style="width: 10%"
        />
        <SortTableColumn
          label="Institute"
          columnName="name"
          :enable="true"
          style="width: 25%"
        />
        <SortTableColumn
          label="E-Mail Address"
          columnName="email"
          :enable="true"
          style="width: 30%"
        />
        <SortTableColumn
          label="Module"
          columnName="module"
          :enable="true"
          style="width: 15%"
        />
        <SortTableColumn
          label="Status"
          columnName="status"
          :enable="true"
          style="width: 10%"
        />
        <div style="width: 10%"></div>
      </template>
      <template #body>
        <TableRow
          v-for="row in overviewData"
          :key="row.id"
          :company="row"
          @companyDeleted="getData"
        />
      </template>
    </OverviewTable>
  </div>
</template>

<script setup>
import { onMounted, ref, watch, reactive } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import { useRoute, useRouter } from "vue-router";
import { useUserStore } from "@/store/user";
import OverviewTable from "@/components/table/OverviewTable.vue";
import TableRow from "./components/TableRow.vue";
import SortTableColumn from "@/components/sort/SortTableColumn.vue";
import axios from "axios";
import { usePermissionStore } from "@/composables/permission";

import { isNumber } from "lodash";

import { trans } from "laravel-vue-i18n";
import AddNewButton from "@/components/Button/AddNewButton.vue";
import Filter from "@/components/Filters/Filter.vue";
import MultiSelectFilter from "@/components/Filters/MultiSelectFilter.vue";

const overviewData = ref([]);
const paginationData = ref({});
const permission = usePermissionStore();

const vRoute = useRoute();
const router = useRouter();
const userStore = useUserStore();
const { user } = storeToRefs(userStore);
const loading = ref(false);

async function getData() {
  const queryParams = { ...vRoute.query };
  try {
    const { data } = await axios.get(
      route("companies.index", { _query: queryParams })
    );

    overviewData.value = data.data;
    paginationData.value = data.meta;
  } catch (error) {
  } finally {
    loading.value = false;
  }
}
getData();

watch(
  () => vRoute.fullPath,
  async () => {
    getData();
  }
);
</script>

<style lang="scss" scoped>
//
</style>
