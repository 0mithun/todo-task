<template>
  <div class="content px-8 py-10">
    <div class="card">
      <BackButton
        :showPopup="isFormChanged"
        title="Cancel institute creation?"
        body="If you cancel this operation, all data will be discarded. Are you sure you want to cancel the creation of this institute?"
      />
      <h3 class="card__title">{{ $t("Edit institute") }}</h3>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <PhotoInput
            button_text="Picture"
            label="Picture"
            v-model="form.logo"
            :defaultImage="defaultImage"
            @changeFile="(e) => {}"
            :croping="false"
            @deleteImage="deleteImage"
          />
        </div>
        <div class="form-column w-[31%]">
          <TextInput
            label="Name"
            :asterisk="true"
            placeholder="Enter institute name"
            v-model="form.name"
            :error="v$.name.$errors[0]?.$message"
            maxLength="40"
            :showError="true"
            @input="
              () => {
                v$.name.$touch();
              }
            "
          />
        </div>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <TextInput
            label="Street Name"
            :asterisk="true"
            placeholder="Enter street name"
            v-model="form.street_name"
            :error="v$.street_name.$errors[0]?.$message"
            maxLength="40"
            :showError="true"
            @input="
              () => {
                v$.street_name.$touch();
              }
            "
          />
        </div>
        <div class="form-column w-[31%]">
          <TextInput
            label="Street number"
            :asterisk="true"
            placeholder="Enter street number"
            v-model="form.street_number"
            :error="v$.street_number.$errors[0]?.$message"
            maxLength="40"
            :showError="true"
            @input="
              () => {
                v$.street_number.$touch();
              }
            "
          />
        </div>
        <div class="form-column w-[31%]">
          <TextInput
            label="City"
            :asterisk="true"
            placeholder="Enter city"
            v-model="form.city"
            :error="v$.city.$errors[0]?.$message"
            maxLength="40"
            :showError="true"
            @input="
              () => {
                v$.city.$touch();
              }
            "
          />
        </div>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <TextInput
            label="Zip Code"
            :asterisk="true"
            placeholder="Enter zip code"
            v-model="form.zip_code"
            :error="v$.zip_code.$errors[0]?.$message"
            maxLength="40"
            :showError="true"
            @input="
              () => {
                v$.zip_code.$touch();
              }
            "
          />
        </div>
        <div class="form-column w-[31%]">
          <CountrySelect
            class=""
            v-model="form.country"
            label="Country"
            :asterisk="true"
            placeholder="Select Country"
            :error="v$.country.$errors[0]?.$message"
            @input="
              () => {
                v$.country.$touch();
              }
            "
            :locale="user.language ?? 'de'"
          />
        </div>
      </div>
      <div class="section__title">
        <h3>{{ $t("Contact person") }}</h3>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <TextInput
            label="First name"
            :asterisk="true"
            placeholder="Enter first name"
            v-model="form.contact_person_first_name"
            :error="v$.contact_person_first_name.$errors[0]?.$message"
            maxLength="40"
            :showError="true"
            @input="
              () => {
                v$.contact_person_first_name.$touch();
              }
            "
          />
        </div>
        <div class="form-column w-[31%]">
          <TextInput
            label="Last name"
            :asterisk="true"
            placeholder="Enter last name"
            v-model="form.contact_person_last_name"
            :error="v$.contact_person_last_name.$errors[0]?.$message"
            maxLength="40"
            :showError="true"
            @input="
              () => {
                v$.contact_person_last_name.$touch();
              }
            "
          />
        </div>
        <div class="form-column w-[31%]"></div>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <PhoneNumberInput
            class=""
            label="Phone Number"
            :asterisk="true"
            v-model:country_code="form.phone_number_iso_code"
            v-model:phone_number="form.phone_number"
            number_placeholder="11 111 11 11"
            :error="
              v$.phone_number_iso_code.$errors.length
                ? v$.phone_number_iso_code.$errors[0].$message
                : v$.phone_number.$errors.length
                ? v$.phone_number.$errors[0].$message
                : null
            "
            @input="
              () => {
                v$.phone_number.$touch();
              }
            "
          />
        </div>
        <div class="form-column w-[31%]">
          <TextInput
            label="E-mail address"
            :asterisk="true"
            placeholder="Enter e-mail"
            v-model="form.email"
            type="email"
            :error="v$.email.$errors[0]?.$message"
            :showError="true"
            @input="
              () => {
                v$.email.$touch();
              }
            "
          />
        </div>
        <div class="form-column w-[31%]"></div>
      </div>

      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <SubmitButton @click.prevent="update" />
        </div>
        <div class="form-column w-[31%]">
          <CancelButton
            :showPopup="isFormChanged"
            title="Cancel institute creation?"
            body="If you cancel this operation, all data will be discarded. Are you sure you want to cancel the creation of this institute?"
          />
        </div>
        <div class="form-column w-[31%]"></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import TextInput from "@/components/form/TextInput.vue";
import PhotoInput from "@/components/form/PhotoInput.vue";
import PhoneNumberInput from "@/components/form/PhoneNumberInput.vue";
import CancelButton from "@/components/Button/CancelButton.vue";
import SubmitButton from "@/components/Button/SubmitButton.vue";
import BackButton from "@/components/Button/BackButton.vue";
import CountrySelect from "@/components/form/CountrySelect.vue";

import Form from "vform";
import { useVuelidate } from "@vuelidate/core";
import { inject, reactive, ref, computed } from "@vue/runtime-core";
import { trans, wTrans } from "laravel-vue-i18n";
import { useRouter, useRoute } from "vue-router";
import { useUserStore } from "@/store/user.js";
import { storeToRefs } from "pinia";
const userStore = useUserStore();
const { user } = storeToRefs(userStore);
const vRouter = useRouter();
const vRoute = useRoute();
const emitter = inject("emitter");

import {
  required,
  email,
  maxLength,
  helpers,
  minLength,
  requiredIf,
  numeric,
  maxValue,
} from "@vuelidate/validators";
import axios from "axios";

const componentKey = ref(0);
const address_selected = (address) => {
  Object.keys(address).forEach((key) => {
    if (form.hasOwnProperty(key)) {
      form[key] = address[key];
    }
  });
  componentKey.value++;
};

const form = reactive(
  new Form({
    name: "",
    street_name: "",
    street_number: "",
    city: "",
    zip_code: "",
    country: "CH",
    contact_person_first_name: "",
    contact_person_last_name: "",
    phone_number: "",
    email: "",
    phone_number_iso_code: "CH",
    logo: null,
    _method: "PUT",
  })
);

const rules = computed(() => {
  return {
    name: {
      required: helpers.withMessage("Please fill name", required),
      maxLength: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 40 }),
        maxLength(40)
      ),
    },
    street_name: {
      required: helpers.withMessage("Please fill street name", required),
    },
    street_number: {
      required: helpers.withMessage("Please fill street number", required),
    },
    city: {
      required: helpers.withMessage("Please fill city", required),
    },
    zip_code: {
      required: helpers.withMessage("Please fill zip code", required),
    },
    country: {
      required: helpers.withMessage("Please select country", required),
    },
    contact_person_first_name: {
      required: helpers.withMessage("Please fill first name", required),
      maxLength: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 40 }),
        maxLength(40)
      ),
    },
    contact_person_last_name: {
      required: helpers.withMessage("Please fill last name", required),
      maxLength: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 40 }),
        maxLength(40)
      ),
    },
    phone_number: {
      required: helpers.withMessage("Please fill phone number", required),
      valid: helpers.withMessage("Invalid phone number", (value) =>
        /^\d[\d\s]*\d$|^\d$/.test(value.trim())
      ),
      maxLength: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 15 }),
        (value) => !value || value.replace(/\s+/g, "").length <= 15
      ),
      minLength: helpers.withMessage(
        wTrans("Minimum :length characters", { length: 4 }),
        (value) => !value || value.replace(/\s+/g, "").length >= 4
      ),
    },
    phone_number_iso_code: {
      //
    },
    email: {
      required: helpers.withMessage("Please fill email", required),
      email: helpers.withMessage("Invalid email format", email),
    },
  };
});
const v$ = useVuelidate(rules, form);
const defaultImage = ref(null);

const deleteImage = async () => {
  try {
    const res = await axios.put(
      route("companies.delete-image", { company: vRoute.params.id })
    );
    defaultImage.value = null;
  } catch (error) {
    console.log(error);
  }
};

const update = async () => {
  v$.value.$touch();
  if (v$.value.$invalid) {
    //emitter.emit("show-invalid-input-modal");
    return;
  }

  try {
    const res = await axios.post(
      route("company.information-update", vRoute.params.id),
      form,
      {
        headers: { "Content-Type": "multipart/form-data" },
      }
    );
    emitter.emit(
      `show-success-notification`,
      wTrans("The institute :name has been successfully updated.", {
        name: form.name,
      })
    );
    vRouter.push({ name: "dashboard" });
  } catch (error) {
    console.log(error);
  }
};

const companyData = ref(null);
const getDeta = async () => {
  try {
    const { data } = await axios.get(route("companies.show", vRoute.params.id));
    const company = data.data;
    companyData.value = data.data;
    //  console.log(company);
    Object.keys(form.data()).forEach((key) => {
      if (company.hasOwnProperty(key)) {
        form[key] = company[key];
      }
    });

    if (company.logo_url && company.logo) {
      defaultImage.value = company.logo_url;
    }
    form.logo = null;
  } catch (error) {
    console.log(error);
  }
};

getDeta();

const isFormChanged = computed(() => {
  if (!companyData.value) return false;
  let isChange = false;

  const keys = Object.keys(form);
  for (let i = 0; i < keys.length; i++) {
    const key = keys[i];
    if (form.logo != null) {
      isChange = true;
    } else {
      if (companyData.value.hasOwnProperty(key)) {
        if (key === "logo") {
          continue;
        }
        if (form[key] != companyData.value[key]) {
          isChange = true;
          break;
        }
      }
    }
  }

  return isChange;
});
</script>

<style lang="scss" scoped></style>
