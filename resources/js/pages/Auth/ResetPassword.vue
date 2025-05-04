<template>
  <AuthLayout>
    <div class="header-img">
      <img src="images/new-logo.png" alt="logo" />
    </div>
    <div class="form-container">
      <h2>{{ $t("Reset password") }}</h2>
      <div class="form">
        <form>
          <div class="mb-4 max-w-[436px]">
            <TextInput
                autofocus
                label="E-Mail"
                :placeholder="$t('Enter e-mail address')"
                :asterisk="true"
                v-model="form.email"
                inputClass="!bg-[#e9f7fe]"
                :readonly="true"
            />

          </div>
          <div class="mb-4 max-w-[436px]">
            <PasswordInput
                label="New Password"
                :placeholder="$t('Enter password')"
                :asterisk="true"
                v-model="form.password"
                :error="v$.password.$errors[0]?.$message"
                @input="
                () => {
                    v$.password.$touch();
                }
                "
                inputClass="!bg-[#e9f7fe]"
            />


          </div>
          <div class="mb-4 max-w-[436px]">
            <PasswordInput
                label="Confirm new password"
                :placeholder="$t('Confirm new password')"
                :asterisk="true"
                v-model="form.confirm_password"
                :error="v$.confirm_password.$errors[0]?.$message"
                @input="
                () => {
                    v$.confirm_password.$touch();
                }
                "
                inputClass="!bg-[#e9f7fe]"
            />
          </div>
          <button
            type="submit"
            @click.prevent="forgetPassword"
            class="login-btn"
          >
            {{ $t("Reset password") }}
          </button>
          <router-link :to="{ name: 'login' }" class="login-url">
            {{ $t("Back to Login") }}
          </router-link>
        </form>
      </div>
    </div>
  </AuthLayout>
</template>

<script setup>
import axios from "axios";
import AuthLayout from "@/layouts/Auth.vue";

import Form from "vform";
import { useVuelidate } from "@vuelidate/core";
import { email, required, helpers } from "@vuelidate/validators";
import { useRouter, useRoute } from "vue-router";
import { reactive, ref, inject, onBeforeMount } from "vue";
import { trans } from "laravel-vue-i18n";

import PasswordInput from "@/components/form/PasswordInput.vue";
import TextInput from "@/components/form/TextInput.vue";

const vueRoute = useRoute();
const router = useRouter();
const emitter = inject("emitter");

const form = reactive(
  new Form({
    email: "",
    password: "",
    confirm_password: "",
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
    required: helpers.withMessage("Passwort muss ausgefüllt werden.", required),
  },
  confirm_password: {
    required: helpers.withMessage("Passwort muss ausgefüllt werden.", required),
    sameAsPassword: helpers.withMessage(
      trans("Password and confirmation do not match."),
      () => form.password == form.confirm_password
    ),
  },
};

const v$ = useVuelidate(rules, form);

form.email = encodeURI(vueRoute.query.email); //vueRoute.query.email
form.token = vueRoute.query.token;
onBeforeMount(() => {
  tokenChecker();
});

const tokenChecker = async () => {
  try {
    const res = await axios.get(
      route("token.check", { _query: vueRoute.query })
    );
  } catch (error) {
    console.log(error);
    if (error.response.status == 422) {
      router.push({ name: "403" });
    }
  }
};

const forgetPassword = async () => {
  try {
    v$.value.$touch();
    if (v$.value.$invalid) {
      return;
    }
    const res = await form.post(route("reset.password"));

    emitter.emit(`show-success-notification`, "Password update successfully");

    setTimeout(() => router.push("login"), 500);
  } catch (error) {
    console.log(error);
    emitter.emit(
      `show-fail-notification`,
      "The selected value for e-mail address is invalid."
    );
  }
};
</script>
<style scoped lang="scss">
.form-container {
  text-align: left;

  width: 70%;
  h2 {
    font-family: "Ubuntu", sans-serif;
    font-style: normal;
    font-weight: 700;
    font-size: 35px;
    line-height: 40px;
    color: #e97d32;
    margin: 70px 0 56px;
  }
  .form {
    h4 {
      font-family: "Ubuntu", sans-serif;
      font-style: normal;
      font-weight: 700;
      font-size: 22px;
      line-height: 25px;
      color: #063f5f;
      margin-bottom: 2rem;
    }
    form label {
      font-family: "Poppins", sans-serif;
      font-style: normal;
      // font-weight: 700;
      font-weight: 600;
      font-size: 18px;
      line-height: 27px;
      display: flex;
      align-items: center;
      color: #16a9b7;
    }

    form input {
      border-radius: 0px;
      border: none;
      background-color: #e9f7fe;
      width: 436px;
      padding: 10px 20px;
      height: 40px;
      font-family: "Poppins", sans-serif;
    }

    form input:focus {
      background-color: #e9f7fe !important;
      outline: none;
    }

    form input::placeholder {
      font-family: "Poppins", sans-serif;
      font-style: normal;
      font-weight: 400;
      font-size: 15px;
      line-height: 23px;

      color: #87b1cb;
    }

    .login-btn {
      width: 100%;
      max-width: 436px;
      height: 40px;
      border-radius: 0px;
      margin-top: 25px;
      background: #e97d32;
      font-family: "Poppins", sans-serif;
      font-style: normal;
      font-weight: 700;
      font-size: 18px;
      line-height: 27px;
      text-align: center;
      color: #ffffff;
    }

    .pass-icon {
      object-fit: contain;
      margin-left: 5px;
      margin-top: -10px;
      width: 9px;
      height: 9px;
    }

    .pass-forgot {
      font-family: "Poppins", sans-serif;
      font-style: normal;
      font-weight: 400;
      font-size: 12px;
      line-height: 18px;
      color: #a0a0a0;
      text-decoration: none;
      display: block;
      margin-top: 16px;
      cursor: pointer;
    }

    .error {
      color: #e74444;
      font-size: 12px;
      font-weight: 600;
    }
  }
}

.login-url {
  color: #e97d32;
  cursor: pointer;
  display: inline-block;
  font-family: Poppins;
  font-size: 16px;
  font-style: normal;
  font-weight: 700;
  line-height: 24px;
  margin-top: 36px;
  text-decoration: none;
}
</style>
