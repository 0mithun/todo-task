<template>
  <div class="content px-8 py-10">
    <div class="card" v-if="company">
      <BackButton />
      <h3 class="card__title">{{ $t("Institute details") }}</h3>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <PhotoInput
            button_text="Picture"
            label="Picture"
            :value="company.logo"
            :defaultImage="company.logo_url"
            @changeFile="(e) => {}"
            :croping="false"
            labelClass="invisible"
          />
        </div>
        <div class="form-column w-[31%]">
          <FormValue label="Name" :value="company.name" :translate="false" />
        </div>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <FormValue
            label="Street Name"
            :value="company.street_name"
            :translate="false"
          />
        </div>
        <div class="form-column w-[31%]">
          <FormValue
            label="Street number"
            :value="company.street_number"
            :translate="false"
          />
        </div>
        <div class="form-column w-[31%]">
          <FormValue label="City" :value="company.city" :translate="false" />
        </div>
      </div>
      <div class="form-row flex-wrap mt-8">
        <!-- <div class="form-column w-[31%]">
          <FormValue label="State" :value="company.state" :translate="false" />
        </div> -->
        <div class="form-column w-[31%]">
          <FormValue label="Zip Code" :value="company.zip_code" />
        </div>
        <div class="form-column w-[31%]">
          <FormValue label="Country" :value="getCountryName(company.country)" />
        </div>
      </div>
      <div class="section__title">
        <h3>{{ $t("Contact person") }}</h3>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <FormValue
            label="First name"
            :value="company.contact_person_first_name"
            :translate="false"
          />
        </div>
        <div class="form-column w-[31%]">
          <FormValue
            label="Last name"
            :value="company.contact_person_last_name"
            :translate="false"
          />
        </div>
        <div class="form-column w-[31%]"></div>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <FormValue label="Phone Number" :value="company.full_phone_number" />
        </div>
        <div class="form-column w-[31%]">
          <FormValue label="E-mail address" :value="company.email" />
        </div>
        <div class="form-column w-[31%]"></div>
      </div>
      <div class="section__title">
        <h3>{{ $t("Financial Distribution Settings") }}</h3>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <FormValue
            label="Institute (%)"
            :value="company.company_percentage"
          />
        </div>
        <div class="form-column w-[31%]"></div>
      </div>
      <div class="section__title flex">
        <h3>{{ $t("Module") }}</h3>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[100%]">
          <div class="flex flex-row gap-6">
            <SquareCheckboxInput
              v-model="company.playgroup"
              checkLabel="playgroup"
              :readOnly="true"
            />
            <SquareCheckboxInput
              v-model="company.daycare"
              checkLabel="Daycare"
              :readOnly="true"
            />
          </div>
        </div>
      </div>
      <div class="section__title flex">
        <h3>{{ $t("Payment Method") }}</h3>
      </div>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[100%]">
          <div class="flex flex-row gap-6">
            <SquareCheckboxInput
              v-model="company.payment_method_online"
              checkLabel="Payment Method Online"
              :readOnly="true"
            />
            <SquareCheckboxInput
              v-model="company.payment_method_invoice"
              checkLabel="Payment Method Invoice"
              :readOnly="true"
            />
          </div>
        </div>
      </div>
      <template v-if="company.payment_method_invoice">
        <div class="section__title flex">
          <h3>{{ $t("Invoice") }}</h3>
        </div>
        <div class="form-row flex-wrap mt-8">
          <div class="form-column w-[31%]">
            <FormValue
              label="Invoice sent name"
              :value="company.invoice_sent_name"
              :translate="false"
            />
          </div>
          <div class="form-column w-[31%]">
            <FormValue
              label="Invoice street name"
              :value="company.invoice_street_name"
              :translate="false"
            />
          </div>
          <div class="form-column w-[31%]">
            <FormValue
              label="Invoice street number"
              :value="company.invoice_street_number"
              :translate="false"
            />
          </div>
          <div class="form-column w-[31%]">
            <FormValue
              label="Invoice city"
              :value="company.invoice_city"
              :translate="false"
            />
          </div>
          <!-- <div class="form-column w-[31%]">
            <FormValue
              label="Invoice state"
              :value="company.invoice_state"
              :translate="false"
            />
          </div> -->
          <div class="form-column w-[31%]">
            <FormValue
              label="Invoice zip code"
              :value="company.invoice_zip_code"
            />
          </div>
          <div class="form-column w-[31%]">
            <FormValue
              label="Invoice Country"
              :value="getCountryName(company.invoice_country)"
            />
          </div>
          <div class="form-column w-[31%]">
            <FormValue
              label="Invoice bank name"
              :value="company.invoice_bank_name"
              :translate="false"
            />
          </div>
          <div class="form-column w-[31%]">
            <FormValue
              label="Invoice bank account no"
              :value="company.invoice_bank_account_no"
              :translate="false"
              style="word-wrap: break-word"
            />
          </div>
          <div class="form-column w-[31%]">
            <FormValue
              label="Invoice bank iban no"
              :value="company.invoice_bank_iban_no"
              :translate="false"
              style="word-wrap: break-word"
            />
          </div>
          <div class="form-column w-[31%]">
            <FormValue
              label="Invoice bank swift code"
              :value="company.invoice_bank_swift_code"
              :translate="false"
            />
          </div>
        </div>
      </template>
      <div class="form-row flex-wrap mt-8">
        <div class="form-column w-[31%]">
          <EditButton routeName="companies.edit" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import PhotoInput from "@/components/form/PhotoInput.vue";
import FormValue from "@/components/form/FormValue.vue";
import BackButton from "@/components/Button/BackButton.vue";
import EditButton from "@/components/Button/EditButton.vue";
import { inject, reactive, ref } from "@vue/runtime-core";
import { trans } from "laravel-vue-i18n";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import SquareCheckboxInput from "@/components/form/SquareCheckboxInput.vue";
const vRouter = useRouter();
const vRoute = useRoute();

const company = ref(null);

const getDetail = async () => {
  try {
    const { data } = await axios.get(route("companies.show", vRoute.params.id));
    company.value = data.data;
  } catch (error) {
    console.log(error);
  }
};

getDetail();
</script>

<style lang="scss" scoped>
.section__title {
  padding-top: 12px;
}
.weekdays-table {
  width: 100%;
}
.weekdays-table .weekday_opening_hours_day {
  margin-top: 20px;
  background: white;
  color: #063f5f;
  font-family: Poppins;
  font-size: 16px;
  font-style: normal;
  font-weight: 600;
  line-height: normal;
}

.weekdays-table .weekday_opening_hours_day--header {
  color: #16a9b7;
  font-family: Poppins;
  font-size: 16px;
  font-style: normal;
  font-weight: 600;
  line-height: normal;
  padding: 10px;
  padding-bottom: 0px;
}

.weekday_opening_hours_day--forms {
}

.weekdays-table .weekday_opening_hours_day--form {
  padding: 5px 10px;
  border-bottom: 1px solid #ddd;

  &:last-child {
    border: none;
    margin-bottom: 0;
  }

  .form-label {
    color: #2c5b7d;
    font-family: Poppins;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;

    margin: 0;
    display: inline;
  }
  .text-input {
    color: #5085ab;
    font-family: Poppins;
    font-size: 14px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
  }
}

.weekdays-table .weekday_opening_hours_day--form .inputs {
  display: flex;
  justify-content: space-between;
}
</style>
