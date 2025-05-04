<template>
  <div
    class="back flex gap-3 items-center cursor-pointer mb-5 w-[100px]"
    @click="redirect"
  >
    <svg
      width="25"
      height="24"
      viewBox="0 0 25 24"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <rect
        x="24.5"
        width="24"
        height="24"
        rx="12"
        transform="rotate(90 24.5 0)"
        fill="white"
      />
      <path
        d="M14.2326 8.4845C14.3365 8.48221 14.4385 8.51233 14.5245 8.57071C14.6105 8.6291 14.6762 8.71286 14.7124 8.81028C14.7485 8.9077 14.7535 9.01396 14.7265 9.11432C14.6995 9.21468 14.6419 9.30409 14.5617 9.37021L11.5021 11.9913L14.5617 14.6115C14.6172 14.6522 14.6636 14.704 14.6982 14.7635C14.7327 14.8231 14.7546 14.8892 14.7624 14.9575C14.7702 15.0259 14.7638 15.0952 14.7436 15.161C14.7235 15.2268 14.6899 15.2878 14.6451 15.34C14.6002 15.3923 14.5451 15.4346 14.4831 15.4646C14.4211 15.4945 14.3536 15.5114 14.2849 15.514C14.2161 15.5167 14.1475 15.5051 14.0834 15.48C14.0193 15.455 13.961 15.4169 13.9123 15.3683L10.4094 12.3712C10.3544 12.3242 10.3102 12.266 10.2799 12.2003C10.2496 12.1346 10.2339 12.0632 10.2339 11.9908C10.2339 11.9185 10.2496 11.847 10.2799 11.7814C10.3102 11.7157 10.3544 11.6574 10.4094 11.6104L13.9123 8.61045C14.0008 8.53185 14.1143 8.48728 14.2326 8.4845Z"
        fill="#4D5A5C"
      />
    </svg>

    <span class="back-text">{{ $t("Back") }}</span>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import { inject } from "@vue/runtime-core";

const router = useRouter();
const props = defineProps({
  target: {
    requred: false,
  },
  back_prev: {
    type: Boolean,
    default: false,
  },
});

const $vfm = inject("$vfm");

const redirect = () => {
  if (props.back_prev) {
    router.back();
  } else {
    props.target ? router.push(props.target) : router.back();
  }
};
</script>


<style lang="scss" scoped>
.back-text {
  color: var(--Nutral-Gray-600, #4d5a5c);
  font-family: Poppins;
  font-size: 14px;
  font-style: normal;
  font-weight: 600;
  line-height: normal;
}
</style>
