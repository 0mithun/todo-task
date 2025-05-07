<template>
  <div class="content px-8 py-10">
    <div class="card">
      <BackButton />
      <h3 class="card__title">{{ $t("Add new institute") }}</h3>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <PhotoInput
            button_text="Picture"
            label="Picture"
            v-model="form.logo"
            @changeFile="(e) => {}"
            :croping="false"
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
        <!-- <div class="form-column w-[31%]">
          <TextInput
            label="State"
            :asterisk="false"
            placeholder="Enter state"
            v-model="form.state"
            :error="v$.state.$errors[0]?.$message"
            maxLength="40"
            :showError="true"
            @input="
              () => {
                v$.state.$touch();
              }
            "
          />
        </div> -->
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
      <div class="section__title">
        <h3>{{ $t("Financial Distribution Settings") }}</h3>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <TextInput
            label="Institute (%)"
            :asterisk="true"
            placeholder="80"
            v-model="form.company_percentage"
            :error="v$.company_percentage.$errors[0]?.$message"
            maxLength="10"
            :showError="true"
            @input="
              () => {
                v$.company_percentage.$touch();
              }
            "
          />
        </div>
        <div class="form-column w-[31%]"></div>
      </div>
      <div class="section__title flex">
        <h3
          :class="{
            'label-error':
              v$.playgroup.$errors[0]?.$message ||
              v$.daycare.$errors[0]?.$message,
          }"
        >
          {{ $t("Module") }}*
        </h3>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[100%]">
          <div class="flex flex-row gap-6">
            <SquareCheckboxInput
              v-model="form.playgroup"
              checkLabel="playgroup"
              @input="
                () => {
                  v$.playgroup.$touch();
                }
              "
              :error="
                v$.playgroup.$errors[0]?.$message ||
                v$.daycare.$errors[0]?.$message
              "
            />
            <SquareCheckboxInput
              v-model="form.daycare"
              checkLabel="Daycare"
              @input="
                () => {
                  v$.daycare.$touch();
                }
              "
            />
          </div>
        </div>
      </div>
      <div class="section__title flex">
        <h3
          :class="{
            'label-error':
              v$.payment_method_online.$errors[0]?.$message ||
              v$.payment_method_invoice.$errors[0]?.$message,
          }"
        >
          {{ $t("Payment Method") }}*
        </h3>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[100%]">
          <div class="flex flex-row gap-6">
            <SquareCheckboxInput
              v-model="form.payment_method_online"
              checkLabel="Payment Method Online"
              @input="
                () => {
                  v$.payment_method_online.$touch();
                }
              "
              :error="
                v$.payment_method_online.$errors[0]?.$message ||
                v$.payment_method_invoice.$errors[0]?.$message
              "
            />
            <SquareCheckboxInput
              v-model="form.payment_method_invoice"
              checkLabel="Payment Method Invoice"
              @input="
                () => {
                  v$.payment_method_invoice.$touch();
                }
              "
            />
          </div>
        </div>
      </div>
      <template v-if="form.payment_method_invoice">
        <div class="section__title flex">
          <h3>{{ $t("Invoice") }}</h3>
          <span>*</span>
        </div>
        <div class="form-row flex-wrap mt-8">
          <div class="form-column w-[31%]">
            <TextInput
              label="Invoice sent name"
              :asterisk="true"
              placeholder="Invoice sent name"
              v-model="form.invoice_sent_name"
              :error="v$.invoice_sent_name.$errors[0]?.$message"
              :showError="true"
              @input="
                () => {
                  v$.invoice_sent_name.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Invoice street name"
              :asterisk="true"
              placeholder="Invoice street name"
              v-model="form.invoice_street_name"
              :error="v$.invoice_street_name.$errors[0]?.$message"
              :showError="true"
              @input="
                () => {
                  v$.invoice_street_name.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Invoice street number"
              :asterisk="true"
              placeholder="Invoice street number"
              v-model="form.invoice_street_number"
              :error="v$.invoice_street_number.$errors[0]?.$message"
              :showError="true"
              @input="
                () => {
                  v$.invoice_street_number.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Invoice city"
              :asterisk="true"
              placeholder="Invoice city"
              v-model="form.invoice_city"
              :error="v$.invoice_city.$errors[0]?.$message"
              :showError="true"
              @input="
                () => {
                  v$.invoice_city.$touch();
                }
              "
            />
          </div>
          <!-- <div class="form-column w-[31%]">
            <TextInput
              label="Invoice state"
              :asterisk="true"
              placeholder="Invoice state"
              v-model="form.invoice_state"
              :error="v$.invoice_state.$errors[0]?.$message"
              :showError="true"
              @input="
                () => {
                  v$.invoice_state.$touch();
                }
              "
            />
          </div> -->
          <div class="form-column w-[31%]">
            <TextInput
              label="Invoice zip code"
              :asterisk="true"
              placeholder="Invoice zip code"
              v-model="form.invoice_zip_code"
              :error="v$.invoice_zip_code.$errors[0]?.$message"
              :showError="true"
              @input="
                () => {
                  v$.invoice_zip_code.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <CountrySelect
              class=""
              v-model="form.invoice_country"
              label="Invoice Country"
              :asterisk="true"
              placeholder="Select Country"
              :error="v$.invoice_country.$errors[0]?.$message"
              @input="
                () => {
                  v$.invoice_country.$touch();
                }
              "
              :locale="user.language ?? 'de'"
            />
          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Invoice bank name"
              :asterisk="true"
              placeholder="Invoice bank name"
              v-model="form.invoice_bank_name"
              :error="v$.invoice_bank_name.$errors[0]?.$message"
              :showError="true"
              @input="
                () => {
                  v$.invoice_bank_name.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Invoice bank account no"
              :asterisk="true"
              placeholder="Invoice bank account no"
              v-model="form.invoice_bank_account_no"
              :error="v$.invoice_bank_account_no.$errors[0]?.$message"
              :showError="true"
              @input="
                () => {
                  v$.invoice_bank_account_no.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Invoice bank iban no"
              :asterisk="true"
              placeholder="Invoice bank iban no"
              v-model="form.invoice_bank_iban_no"
              :error="v$.invoice_bank_iban_no.$errors[0]?.$message"
              :showError="true"
              @input="
                () => {
                  v$.invoice_bank_iban_no.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Invoice bank swift code"
              :asterisk="true"
              placeholder="Invoice bank swift code"
              v-model="form.invoice_bank_swift_code"
              :error="v$.invoice_bank_swift_code.$errors[0]?.$message"
              :showError="true"
              @input="
                () => {
                  v$.invoice_bank_swift_code.$touch();
                }
              "
            />
          </div>
        </div>
      </template>

      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <SubmitButton
            @click.prevent="create"
            :class="{ 'btn-disabled': loading }"
          />
        </div>
        <div class="form-column w-[31%]">
          <CancelButton
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
import SquareCheckboxInput from "@/components/form/SquareCheckboxInput.vue";
import CancelButton from "@/components/Button/CancelButton.vue";
import SubmitButton from "@/components/Button/SubmitButton.vue";
import BackButton from "@/components/Button/BackButton.vue";
import CountrySelect from "@/components/form/CountrySelect.vue";
import GoogleMapAutoComplete from "@/components/form/GoogleMapAutoComplete.vue";
import GoogleMapAddressInput from "@/components/form/GoogleMapAddressInput.vue";
import Form from "vform";
import { useVuelidate } from "@vuelidate/core";
import { computed, inject, reactive, ref } from "@vue/runtime-core";
import { trans, wTrans } from "laravel-vue-i18n";
import { useRouter } from "vue-router";
import { useUserStore } from "@/store/user.js";
import { storeToRefs } from "pinia";
const userStore = useUserStore();
const { user } = storeToRefs(userStore);
const vRouter = useRouter();
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
    // state: "",
    zip_code: "",
    country: "CH",
    contact_person_first_name: "",
    contact_person_last_name: "",
    phone_number: "",
    email: "",
    phone_number_iso_code: "CH",
    logo: null,
    status: "active",
    playgroup: false,
    daycare: false,
    company_percentage: "",
    payment_method_online: false,
    payment_method_invoice: false,
    invoice_sent_name: "",
    invoice_street_name: "",
    invoice_street_number: "",
    invoice_city: "",
    // invoice_state: "",
    invoice_zip_code: "",
    invoice_country: "CH",
    invoice_bank_name: "",
    invoice_bank_account_no: "",
    invoice_bank_iban_no: "",
    invoice_bank_swift_code: "",
    prefix_id: "",
  })
);

const atLeastOneModuleSelected = helpers.withMessage(
  "Please select at least one module",
  (value, parentVm) => parentVm.playgroup || parentVm.daycare
);

const atLeastOnePaymentSelected = helpers.withMessage(
  "Please select at least one payment method",
  (value, parentVm) =>
    parentVm.payment_method_online || parentVm.payment_method_invoice
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
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    street_number: {
      required: helpers.withMessage("Please fill street number", required),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    city: {
      required: helpers.withMessage("Please fill city", required),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    //   state: {
    //     //
    //   },
    zip_code: {
      required: helpers.withMessage("Please fill zip code", required),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
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
    playgroup: {
      atLeastOneModuleSelected,
    },
    daycare: {
      atLeastOneModuleSelected,
    },
    payment_method_online: {
      atLeastOnePaymentSelected,
    },
    payment_method_invoice: {
      atLeastOnePaymentSelected,
    },
    email: {
      required: helpers.withMessage("Please fill email", required),
      email: helpers.withMessage("Invalid email format", email),
    },
    company_percentage: {
      required: helpers.withMessage("Please fill company percentage", required),
      max: helpers.withMessage(
        wTrans("Maximum percentage :amount possible", { amount: 99 }),
        maxValue(99)
      ),
      number: helpers.withMessage("Must be a number", numeric),
    },
    invoice_sent_name: {
      requiredIf: helpers.withMessage(
        "Please fill name",
        requiredIf(() => form.payment_method_invoice)
      ),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    invoice_street_name: {
      requiredIf: helpers.withMessage(
        "Please fill street name",
        requiredIf(() => form.payment_method_invoice)
      ),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    invoice_street_number: {
      requiredIf: helpers.withMessage(
        "Please fill street number",
        requiredIf(() => form.payment_method_invoice)
      ),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    invoice_city: {
      requiredIf: helpers.withMessage(
        "Please fill city",
        requiredIf(() => form.payment_method_invoice)
      ),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    //   invoice_state: {
    //     //
    //   },
    invoice_zip_code: {
      requiredIf: helpers.withMessage(
        "Please fill zip code",
        requiredIf(() => form.payment_method_invoice)
      ),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    invoice_country: {
      requiredIf: helpers.withMessage(
        "Please select country",
        requiredIf(() => form.payment_method_invoice)
      ),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    invoice_bank_name: {
      requiredIf: helpers.withMessage(
        "Please fill bank name",
        requiredIf(() => form.payment_method_invoice)
      ),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    invoice_bank_account_no: {
      requiredIf: helpers.withMessage(
        "Please fill bank account no",
        requiredIf(() => form.payment_method_invoice)
      ),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
    invoice_bank_iban_no: {
      requiredIf: helpers.withMessage(
        "Please fill iban no",
        requiredIf(() => form.payment_method_invoice)
      ),
    },
    invoice_bank_swift_code: {
      requiredIf: helpers.withMessage(
        "Please fill swift code",
        requiredIf(() => form.payment_method_invoice)
      ),
      max: helpers.withMessage(
        wTrans("Maximum :length characters", { length: 255 }),
        maxLength(255)
      ),
    },
  };
});

const loading = ref(false);

const create = async () => {
  v$.value.$touch();
  if (v$.value.$invalid) {
    //emitter.emit("show-invalid-input-modal");
    return;
  }
  loading.value = true;

  try {
    const res = await axios.post(route("companies.store"), form, {
      headers: { "Content-Type": "multipart/form-data" },
    });
    // console.log(res);
    emitter.emit(
      `show-success-notification`,
      "The institute was successfully created."
    );

    vRouter.push({ name: "companies.index" });
  } catch (error) {
    console.log(error);
  } finally {
    loading.value = false;
  }
};

const v$ = useVuelidate(rules, form);
</script>

<style lang="scss" scoped>
//
</style>
