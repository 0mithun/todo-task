<template>
  <div
    class="flex justify-center items-center bg-[#E9F7FE] w-full p-4 h-[64px]"
  >
    <div v-if="user.role == 'system_admin'" class="logo">
      <router-link :to="{ name: 'companies.index' }">
        <Logo />
      </router-link>
    </div>
    <div v-else class="logo">
      <router-link :to="{ name: 'services.index' }">
        <Logo />
      </router-link>
    </div>
    <div class="ml-auto">
      <div
        class="flex items-center text-white cursor-pointer mr-3"
        @click="dropdownOpen = !dropdownOpen"
      >
        <div
          class="avatar w-[43px] h-[43px] flex items-center justify-center mr-2 overflow-hidden"
        >
          <img
            :src="user.avatar_url"
            alt="admin"
            class="object-contain rounded-full"
            v-if="user.avatar_url"
          />
        </div>
        <div class="user_information text-neutral-700 font-medium font-poppins">
          <h4 class="">{{ user.name }}</h4>
          <p>{{ $t(user.role) }}</p>
        </div>
        <div class="ml-2">
          <svg
            width="14"
            height="14"
            viewBox="0 0 22 14"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="down-arrow"
          >
            <path
              d="M2.6665 2.66666L10.9998 11L19.3332 2.66666"
              stroke="#063F5F"
              stroke-width="3"
              stroke-linecap="square"
            />
          </svg>
        </div>
      </div>
      <div
        class="nav_dropdown_menu hover:cursor-pointer ml-1 text-white relative self-start"
      >
        <div
          class="nav_dropdown_items absolute min-w-[280px]"
          v-click-away="() => (dropdownOpen = false)"
          v-if="dropdownOpen"
        >
          <ul>
            <li
              @click="router.push({ name: 'profile' })"
              class="hover:bg-slate-50"
            >
              {{ $t("Change profile settings") }}
            </li>
            <li
              v-if="user.role == 'service_admin'"
              @click="
                router.push({
                  name: 'companies.information.edit',
                  params: { id: user.company_id },
                })
              "
              class="hover:bg-slate-50"
            >
              {{ $t("Change Company Information") }}
            </li>
            <li
              @click="logout"
              class="hover:bg-slate-50"
              style="color: #e97d32; border-top: 1px solid #fef1e7"
            >
              {{ $t("Log out") }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { loadLanguageAsync } from "laravel-vue-i18n";

import { useUserStore } from "@/store/user";
import { computed, onMounted, ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

import Logo from "@/components/icons/Logo.vue";

const router = useRouter();
const userStore = useUserStore();

const user = computed(() => {
  return userStore.user;
});

const dropdownOpen = ref(false);

const logout = () => {
  localStorage.setItem("is_impersonate", false);
  axios
    .post(route("logout"))
    .then((res) => {
      location.reload();
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<style lang="scss" scoped>
.nav_dropdown_items {
  top: 10px;
  right: 0;
  list-style: none;
  background: #ffffff;
  border: 1px solid #e6dee5;
  filter: drop-shadow(-2px 4px 14px rgba(91, 91, 91, 0.25));
  z-index: 99999;

  li {
    padding: 15px 24px;

    font-family: Poppins;
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: 23px;
    padding: 10px 16px;
    color: #063f5f;

    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 17px;
    position: relative;

    .sub-dropdown {
      min-width: 150px;
      position: absolute;
      top: 0;
      list-style: none;
      background: #ffffff;
      border: 1px solid #e6dee5;
      border-radius: 10px;
      // filter: drop-shadow(-2px 4px 14px rgba(91, 91, 91, 0.25));
      z-index: 99999;

      li {
        padding: 15px 24px;
        font-family: "Inter";
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 19px;
      }
    }
  }
}
.user_information {
  h4 {
    color: var(--Primary-Astronaut-Blue, #063f5f);
    /* Nexa Bold / 18 */
    font-family: Nexa;
    font-size: 18px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
  }

  p {
    color: var(--Primary-Astronaut-Blue, #063f5f);
    /* Ubuntu / Regular / 15 */
    font-family: Ubuntu;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
  }
}

.caret {
  margin-top: -10px;
}

.logo {
  // position: absolute;
  // top: 10;
  // left: 50%;
  // transform: translateX(-50%);
  margin-left: 15px;
}
</style>
