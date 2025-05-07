<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Register your account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" @submit.prevent="register">
        <div>
        <label for="name" class="input--label">Name</label>
        <div class="mt-2">
          <input type="name" id="name"  class="input--field" v-model="form.name" @input="() => v$.name.$touch()">
          <span class="error" v-if="v$.name.$invalid">{{ v$.name.$errors[0]?.$message }}</span>
        </div>
      </div>
      <div>
        <label for="email" class="input--label">Email address</label>
        <div class="mt-2">
          <input type="email" id="email"  class="input--field" v-model="form.email" @input="() => v$.email.$touch()">
          <span class="error" v-if="v$.email.$invalid">{{ v$.email.$errors[0]?.$message }}</span>
          <span class="error" v-if="emailError">{{ emailError }}</span>

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
      <div>
        <div class="flex items-center justify-between">
          <label for="password_confirmation" class="input--label">Confirm Password</label>
        </div>
        <div class="mt-2">
          <input type="password" id="password_confirmation" class="input--field" v-model="form.password_confirmation" @input="() => v$.password_confirmation.$touch()">
          <span class="error" v-if="v$.password_confirmation.$invalid">{{ v$.password_confirmation.$errors[0]?.$message }}</span>
        </div>
      </div>

      <div>
        <button type="submit" class="submit-btn">Sign Up</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6 text-gray-500">
      Already have an account?
      <router-link :to="{name: 'login'}" class="link">Sign In</router-link>
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
const emitter = inject("emitter");


const emailError = ref(null)
const form = reactive(
  new Form({
    name: "",
    email: "",
    password: "",
    password_confirmation: ""
  })
);

const rules = {
    name: {
        required: helpers.withMessage(
            "Namd must be filled in.",
            required
        ),
    },
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
  password_confirmation: {
    required: helpers.withMessage(
      "Confirm Password must be filled in.",
      required
    ),
    sameAsPassword: helpers.withMessage(
      "Password and confirmation do not match.",
      () => form.password == form.password_confirmation
    ),
  },
};

const v$ = useVuelidate(rules, form);

const register = async () => {
  try {
    emailError.value = false
    v$.value.$touch();
    if (v$.value.$invalid) {
      return;
    }
    const res = await form.post(route("register"));
    emitter.emit(`show-success-notification`, "Register successfully");

    router.push({ name: "login" });
  } catch (error) {
    console.log(error)
    if(error.response.status === 422 &&  error.response.data.errors.email) {
        emailError.value = error.response.data.errors.email[0]
    }
  }
};
</script>
<style scoped lang="scss">

</style>
