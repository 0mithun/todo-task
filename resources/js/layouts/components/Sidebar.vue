<template>
  <nav
    id="sidebar"
    class="bg-[#063F5F] h-auto ease-in-out duration-300 w-[300px]"
  >
    <div
      class="relative h-screen min-h-content flex flex-col"
      :class="{ 'collapse-nav': !sidebarFullView }"
      style="min-height: 100vh !important"
    >
      <div class="menu flex flex-col justify-between flex-grow">
        <div class="flex-grow overflow-auto mt-5">
          <!-- <SidebarLink
            v-if="
              hasAnyPermissions(['dashboard.view']) &&
              (userStore.user.role == 'manager' ||
                userStore.user.role == 'company_manager' ||
                userStore.user.role == 'system_admin'
              )
            "
            :routeName="userStore.user.role == 'system_admin' ? 'admin.dashboard' : 'dashboard'"
            :isActive="$route.name == 'dashboard' || $route.name == 'admin.dashboard'"
            :isFullView="sidebarFullView"
          >
            <template #icon>
              <Dashboard />
            </template>
            {{ $t("Dashboard") }}
          </SidebarLink> -->

          <SidebarLink
            class="mt-[40px]"
            routeName="companies.index"
            :isActive="
              isInclude([
                'companies.index',
                'companies.create',
                'companies.edit',
                'companies.show',
              ])
            "
            :isFullView="sidebarFullView"
            v-if="hasAnyPermissions(['companies.view', 'companies.edit'])"
          >
            <template #icon>
              <CompanyIcon />
            </template>
            {{ $t("Institutes") }}
          </SidebarLink>
          <SidebarLink
            routeName="service-admins.index"
            :isActive="
              isInclude([
                'service-admins.index',
                'service-admins.create',
                'service-admins.edit',
                'services.manage-slot',
              ])
            "
            :isFullView="sidebarFullView"
            v-if="
              hasAnyPermissions(['service-admins.view', 'service-admins.edit'])
            "
          >
            <template #icon>
              <ServiceAdminIcon />
            </template>
            {{ $t("Service Admins") }}
          </SidebarLink>

          <SidebarLink
            routeName="services.index"
            :isActive="
              isInclude([
                'services.index',
                'services.create',
                'services.edit',
                'services.show',
                'services.manage-slot',
              ])
            "
            :isFullView="sidebarFullView"
            v-if="hasAnyPermissions(['services.view', 'services.edit'])"
          >
            <template #icon>
              <ServiceIcon />
            </template>
            {{ $t("Services") }}
          </SidebarLink>

          <SidebarLink
            routeName="users.index"
            :isActive="
              isInclude([
                'users.index',
                'users.create',
                'users.edit',
                'users.show',
              ])
            "
            :isFullView="sidebarFullView"
            v-if="hasAnyPermissions(['users.view', 'users.edit'])"
          >
            <template #icon>
              <UserIcon />
            </template>
            {{ $t("Users") }}
          </SidebarLink>

          <SidebarLink
            routeName="sessions.index"
            :isActive="
              isInclude(['sessions.index', 'sessions.create', 'sessions.edit'])
            "
            :isFullView="sidebarFullView"
            v-if="hasAnyPermissions(['sessions.view', 'sessions.edit'])"
          >
            <template #icon>
              <SessionIcon />
            </template>
            {{ $t("Sessions") }}
          </SidebarLink>

          <SidebarLink
            routeName="reviews.index"
            :isActive="isInclude(['reviews.index'])"
            :isFullView="sidebarFullView"
            v-if="hasAnyPermissions(['reviews.view', 'reviews.edit'])"
          >
            <template #icon>
              <CommunicationIcon />
            </template>
            {{ $t("Rating & Reviews") }}
          </SidebarLink>
          <SidebarLink
            routeName="notices.index"
            :isActive="
              isInclude([
                'notices.index',
                'notices.create',
                'notices.edit',
                'notices.show',
              ])
            "
            :isFullView="sidebarFullView"
            v-if="hasAnyPermissions(['notices.view', 'notices.edit'])"
          >
            <template #icon>
              <NoticeIcon />
            </template>
            {{ $t("Notices") }}
          </SidebarLink>
          <SidebarLink
            routeName="conversations.index"
            :isActive="
              isInclude([
                'conversations.index',
                'conversations.create',
                'conversations.show',
              ])
            "
            :isFullView="sidebarFullView"
            v-if="
              hasAnyPermissions(['conversations.view', 'conversations.edit'])
            "
          >
            <template #icon>
              <ConversationIcon />
            </template>
            {{ $t("Conversation") }}
          </SidebarLink>

          <SidebarLink
            routeName="service-registrations.index"
            :isActive="
              isInclude([
                'service-registrations.index',
                'service-registrations.show',
                'service-registrations-invitations.index',
              ])
            "
            :isFullView="sidebarFullView"
            v-if="hasAnyPermissions(['service-registrations.view'])"
          >
            <template #icon>
              <RegistrationIcon />
            </template>
            {{ $t("Registrations") }}
          </SidebarLink>

          <SidebarLink
            routeName="invoices.index"
            :isActive="isInclude(['invoices.index', 'invoices.show'])"
            :isFullView="sidebarFullView"
            v-if="hasAnyPermissions(['invoices.view'])"
          >
            <template #icon>
              <InvoiceIcon />
            </template>
            {{ $t("Invoices") }}
          </SidebarLink>
        </div>
        <div class="text-[#BEE7FB] mb-4 company">
          <div class="flex items-center justify-center py-5 px-5">
            <LanguageSwitcher />
          </div>
          <!-- <div
            class="flex items-center py-3 px-5"
            v-if="userStore.user.role != 'system_admin'"
          >
            <div class="icon">
              <ImageShow
                v-if="userStore.user.company?.logo"
                :image="userStore.user.company?.logo_url"
              />
              <AvatarIcon :width="40" :height="40" v-else />
            </div>
            <div class="sm:hidden md:block ml-4 font-poppins font-medium link">
              {{ userStore.user.company?.name }}
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import SidebarLink from "./SidebarLink.vue";

import HomeIcon from "./Icons/HomeIcon.vue";
import ServiceIcon from "./Icons/ServiceIcon.vue";
import PlanningIcon from "./Icons/PlanningIcon.vue";
import UserIcon from "./Icons/UserIcon.vue";
import CompanyIcon from "./Icons/CompanyIcon.vue";
import CommunicationIcon from "./Icons/CommunicationIcon.vue";
import ServiceAdminIcon from "./Icons/ServiceAdminIcon.vue";
import SessionIcon from "./Icons/SessionIcon.vue";
import ConversationIcon from "./Icons/ConversationIcon.vue";
import RegistrationIcon from "./Icons/RegistrationIcon.vue";
import NoticeIcon from "./Icons/NoticeIcon.vue";
import InvoiceIcon from "./Icons/InvoiceIcon.vue";

import { onBeforeMount, reactive, ref, computed } from "vue";
import { useRoute } from "vue-router";
import { useUserStore } from "@/store/user";
import { storeToRefs } from "pinia";
import InvoiceIconVue from "./Icons/InvoiceIcon.vue";
import ImageShow from "@/components/form/ImageShow.vue";
import AvatarIcon from "@/components/icons/AvatarIcon.vue";

import LanguageSwitcher from "./LanguageSwitcher.vue";

const vRoute = useRoute();
const userStore = useUserStore();

const sidebarFullView = ref(true);
const dataCount = ref({});
const collapseSidebar = () => (sidebarFullView.value = false);
const expandSidebar = () => (sidebarFullView.value = true);
const componentKey = ref(0);

const isInclude = (routeNames = []) => {
  return routeNames.includes(vRoute.name);
};
</script>

<style lang="scss" scoped>
#sidebar {
  box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.25);
  flex: none;
}
.company {
  color: #bee7fb;
  /* Ubuntu / Regular / 22 */
  font-family: Ubuntu;
  font-size: 18px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
  position: fixed;
  width: 100%;
  bottom: 0;
  left: 0;
  margin: 0;

  width: 275px;
}
</style>
