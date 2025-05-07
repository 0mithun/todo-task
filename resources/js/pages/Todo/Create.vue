<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Create Todo</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" @submit.prevent="submit">
        <div>
        <label for="title" class="input--label">Title</label>
        <div class="mt-2">
          <input type="title" id="title"  class="input--field" v-model="form.title" @input="() => v$.title.$touch()">
          <span class="error" v-if="v$.title.$invalid">{{ v$.title.$errors[0]?.$message }}</span>
        </div>
      </div>
      <div>
        <label for="body" class="input--label">Body</label>
        <div class="mt-2">
          <textarea type="body" id="body" rows="5"  class="input--field" v-model="form.body" @input="() => v$.body.$touch()"></textarea>
          <span class="error" v-if="v$.body.$invalid">{{ v$.body.$errors[0]?.$message }}</span>
        </div>
      </div>

      <div>
        <button type="submit" class="submit-btn cursor-pointer">Save</button>
      </div>
    </form>
  </div>
</div>
</template>

<script setup>
import axios from "axios";
import AuthLayout from "@/layouts/Auth.vue";

import Form from "vform";
import { useVuelidate } from "@vuelidate/core";
import { maxLength, required, helpers } from "@vuelidate/validators";
import { useRouter, useRoute } from "vue-router";
import { reactive, ref, inject } from "vue";

const vRouter = useRouter();
const emitter = inject("emitter");


const form = reactive(
  new Form({
    title: "",
    body: "",
  })
);

const rules = {
    title: {
        required: helpers.withMessage(
            "Title must be filled in.",
            required
        ),
        maxLength: helpers.withMessage(
            "Maximum length 255 character",
            maxLength(255)
        ),
    },
  body: {
    required: helpers.withMessage(
      "Body must be filled in.",
      required
    ),
  },
};

const v$ = useVuelidate(rules, form);

const submit = async () => {
  try {
    v$.value.$touch();
    if (v$.value.$invalid) {
      return;
    }
    const res = await form.post(route("todos.store"));

    emitter.emit(`show-success-notification`, "Todo successfully created");

    vRouter.push({ name: "todo.index" });
  } catch (error) {
    emitter.emit(`show-fail-notification`, "Something went wrong please try again");
  }
};
</script>
<style scoped lang="scss">

</style>
