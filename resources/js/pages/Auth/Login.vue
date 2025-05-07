<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" @submit.prevent="login">
      <div>
        <label for="email" class="input--label">Email address</label>
        <div class="mt-2">
          <input type="email" id="email"  class="input--field" v-model="form.email" @input="() => v$.email.$touch()">
          <span class="error" v-if="v$.email.$invalid">{{ v$.email.$errors[0]?.$message }}</span>
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="input--label">Password</label>
        </div>
        <div class="mt-2">
          <input type="password" id="password" class="input--field" v-model="form.password" @input="() => v$.password.$touch()">
          <span class="error" v-if="v$.password.$invalid">{{ v$.password.$errors[0]?.$message }}</span>
        </div>
      </div>
      <div class="">
        <span class="error" v-if="errorMsg">{{ errorMsg }}</span>
      </div>

      <div>
        <button type="submit" class="submit-btn">Sign in</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6 text-gray-500">
      Not a member?
      <router-link :to="{name: 'register'}" class="link">Register Now</router-link>
    </p>
  </div>
</div>
</template>

<script setup>
import axios from "axios";

import Form from "vform";
import { useVuelidate } from "@vuelidate/core";
import { email, required, helpers } from "@vuelidate/validators";
import { useRouter, useRoute } from "vue-router";
import { reactive, ref, inject } from "vue";
import { useUserStore } from "@/store/user";

const userStore = useUserStore();
const router = useRouter();
const errorMsg = ref(null)
const emitter = inject("emitter");


const form = reactive(
  new Form({
    email: "",
    password: "",
  })
);

const rules = {
  email: {
    email: helpers.withMessage(
      "Invalid email, please add a valid email address",
      email
    ),
    required: helpers.withMessage(
      "E-mail address must be filled in.",
      required
    ),
  },
  password: {
    required: helpers.withMessage(
      "Password must be filled in.",
      required
    ),
  },
};

const v$ = useVuelidate(rules, form);

const login = async () => {
  try {
    v$.value.$touch();
    if (v$.value.$invalid) {
      return;
    }
    const res = await form.post(route("login"));
    userStore.setData(res.data);
    emitter.emit(`show-success-notification`, "Login successfully");

    router.push({ name: "dashboard" });
  } catch (error) {
    if (error.response.status == 401) {
      errorMsg.value = "Invalid credentials! Please try again.";

    }
  }
};
</script>
<style scoped lang="scss">

</style>
