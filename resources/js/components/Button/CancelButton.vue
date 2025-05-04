<template>
  <button class="cancel_button" @click="cancel">
    {{ $t("Cancel") }}
  </button>
</template>

<script setup>
import { useRouter } from "vue-router";
import { defineProps, inject } from "vue";

const props = defineProps({
  routeName: {
    type: String,
    default: null,
  },
  body: {
    type: String,
    default: "",
  },
  title: {
    type: String,
    default: "",
  },
  showPopup: {
    type: Boolean,
    default: false,
  },
});

const router = useRouter();
const emitter = inject("emitter");

const cancel = () => {
  if (props.showPopup) {
    emitter.emit("show-cancel-modal", {
      title: props.title,
      body: props.body,
      routeName: props.routeName,
    });
  } else {
    if (window.history.length > 1) {
      router.back();
    } else {
      router.push({ name: "service.index" });
    }
  }
};
</script>

<style lang="scss" scoped>
.cancel_button {
  width: 100%;
  background: #f8d3ba;
  height: 40px;
  text-align: center;
  cursor: pointer;

  color: var(--1-4, #2c5b7d);
  font-family: Nexa;
  font-size: 18px;
  font-weight: 700;
  line-height: normal;
}
</style>
