<template>
  <div class="table__menubar" v-click-away="() => (openDropdownMenu = false)">
    <ThreeDotIcon @click="openDropdownMenu = !openDropdownMenu" />
    <ul class="table__menubar__dropdown" v-if="openDropdownMenu">
      <li>
        <router-link
          :to="{ name: 'companies.edit', params: { id: company.id } }"
          >{{ $t("Edit") }}</router-link
        >
      </li>
      <li>
        <router-link
          :to="{ name: 'companies.show', params: { id: company.id } }"
          >{{ $t("View details") }}</router-link
        >
      </li>
      <li>
        <a
          @click.prevent="
            () => {
              openConfirmModal = true;
              openDropdownMenu = false;
            }
          "
        >
          {{ status == "active" ? $t("Deactivate") : $t("Activate") }}</a
        >
      </li>
      <li>
        <a
          @click.prevent="
            () => {
              openDeleteConfirmModal = true;
              openDropdownMenu = false;
            }
          "
        >
          {{ $t("Delete") }}</a
        >
      </li>
    </ul>
  </div>
  <ConfirmModal
    :company="company"
    v-if="openConfirmModal"
    @close="openConfirmModal = false"
  />
  <DeleteConfirmModal
    :company="company"
    v-if="openDeleteConfirmModal"
    @close="openDeleteConfirmModal = false"
    @companyDeleted="companyDeleted"
  />
</template>

<script>
import axios from "axios";
import ThreeDotIcon from "@/components/icons/ThreeDotIcon.vue";
import ConfirmModal from "./ConfirmModal.vue";
import DeleteConfirmModal from "./DeleteConfirmModal.vue";

export default {
  components: { ThreeDotIcon, ConfirmModal, DeleteConfirmModal },
  props: {
    company: {
      type: Object,
      requied: true,
    },
  },
  data() {
    return {
      openDropdownMenu: false,
      openConfirmModal: false,
      openDeleteConfirmModal: false,
      status: this.company.status,
    };
  },
  methods: {
    companyDeleted() {
      this.$emit("companyDeleted");
    },
  },
};
</script>

<style lang="scss" scoped></style>
