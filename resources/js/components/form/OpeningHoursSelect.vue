<template>
    <div class="opening_hours_select">
        <div class="weekday_selector">
            <div class="weekdays_dropdown">
                    <label class="flex items-center justify-between px-3 py-2 cursor-pointer" @click="weekdaysDropdownOpen = !weekdaysDropdownOpen">
                        {{ $t('Select weekday') }}
                        <DownArrow v-if="!weekdaysDropdownOpen" />
                        <UpArrow v-if="weekdaysDropdownOpen" />
                    </label>
                <ul v-if="weekdaysDropdownOpen" class="weekday_dropdown_options" v-click-away="()=>weekdaysDropdownOpen = false">
                    <li v-for="weekday in  availableWeekDays" :key="weekday" @click="addWeekday(weekday)">{{ $t(weekday) }}</li>
                </ul>
            </div>
            <div class="selected_weekdays">
                <div class="weekday" v-for="weekday in selected_weekdays" :key="weekday">{{ $t(weekday) }}
                    <span @click="removeWeekday(weekday)" class="cursor-pointer">
                        <svg width="22" height="22" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.9525 3.745C11.8353 3.62783 11.6764 3.56201 11.5106 3.56201C11.3449 3.56201 11.186 3.62783 11.0688 3.745L8.20252 6.61125L5.33627 3.745C5.21907 3.62783 5.06013 3.56201 4.8944 3.56201C4.72867 3.56201 4.56973 3.62783 4.45252 3.745C4.33535 3.86221 4.26953 4.02115 4.26953 4.18688C4.26953 4.35261 4.33535 4.51155 4.45252 4.62875L7.31877 7.495L4.45252 10.3613C4.33535 10.4785 4.26953 10.6374 4.26953 10.8031C4.26953 10.9689 4.33535 11.1278 4.45252 11.245C4.56973 11.3622 4.72867 11.428 4.8944 11.428C5.06013 11.428 5.21907 11.3622 5.33627 11.245L8.20252 8.37875L11.0688 11.245C11.186 11.3622 11.3449 11.428 11.5106 11.428C11.6764 11.428 11.8353 11.3622 11.9525 11.245C12.0697 11.1278 12.1355 10.9689 12.1355 10.8031C12.1355 10.6374 12.0697 10.4785 11.9525 10.3613L9.08627 7.495L11.9525 4.62875C12.0697 4.51155 12.1355 4.35261 12.1355 4.18688C12.1355 4.02115 12.0697 3.86221 11.9525 3.745Z" fill="white"/>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
        <div class="weekday_opening_hours">
           <div class="weekday_opening_hours_day"  v-for="weekday in selected_weekdays" :key="weekday">
                <div class="weekday_opening_hours_day--header flex justify-between items-center">
                    <span>{{ $t(weekday) }}</span>
                    <button class="w-[210px] flex items-center justify-between add_session_btn" @click.prevent="addSession(weekday)">{{ $t('Add Session') }}
                        <svg  width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="12" fill="#FEFEFE" fill-opacity="0.3"></circle> <g clip-path="url(#clip0_1472_17041)"><path d="M13.0714 11.1071C12.9728 11.1071 12.8929 11.0272 12.8929 10.9286V7H11.1071V10.9286C11.1071 11.0272 11.0272 11.1071 10.9286 11.1071H7V12.8929H10.9286C11.0272 12.8929 11.1071 12.9728 11.1071 13.0714V17H12.8929V13.0714C12.8929 12.9728 12.9728 12.8929 13.0714 12.8929H17V11.1071H13.0714Z" fill="white"></path></g> <defs><clipPath id="clip0_1472_17041"><rect width="16.558" height="16" fill="white" transform="translate(4 4)"></rect></clipPath></defs></svg>
                    </button>
                </div>
                <div class="weekday_opening_hours_day--forms">
                    <div class="weekday_opening_hours_day--form" v-for="(weekday_form, index) in form[weekday]" :key="`${weekday}-${index}`">
                        <div class="inputs">
                            <div style="width: 100px">
                                <TextInput
                                    label="Start time"
                                    placeholder="00:00"
                                    v-model="form[weekday][index]['start_time']"
                                    labelClass="!mb-1"
                                    :error="v$.form[weekday][index]['start_time'].$errors[0]?.$message "
                                    @input=" () => { v$.form[weekday][index]['start_time'].$touch(); }"
                                />
                            </div>
                            <div style="width: 100px">
                                <TextInput
                                    label="End time"
                                    placeholder="00:00"
                                    v-model="form[weekday][index]['end_time']"
                                    labelClass="!mb-1"
                                    :error="v$.form[weekday][index]['end_time'].$errors[0]?.$message "
                                    @input=" () => { v$.form[weekday][index]['end_time'].$touch(); }"
                                />
                            </div>
                            <div style="width: 19%">
                                <TextInput
                                    label="Minimum occupancy"
                                    placeholder="Input"
                                    v-model="form[weekday][index]['minimum_occupancy']"
                                    labelClass="!mb-1"
                                    :error="v$.form[weekday][index]['minimum_occupancy'].$errors[0]?.$message "
                                    @input=" () => { v$.form[weekday][index]['minimum_occupancy'].$touch(); }"
                                />
                            </div>
                            <div style="width: 19%">
                                <TextInput
                                    label="Maximum occupancy"
                                    placeholder="Input"
                                    v-model="form[weekday][index]['maximum_occupancy']"
                                    labelClass="!mb-1"
                                    :error="v$.form[weekday][index]['maximum_occupancy'].$errors[0]?.$message "
                                    @input=" () => { v$.form[weekday][index]['maximum_occupancy'].$touch(); }"
                                />
                            </div>
                            <div style="width: 19%">
                                <SingleSelect
                                    label="Service leader"
                                    :options="service_leaders"
                                    valueKey="id"
                                    placeholder="Service leader"
                                    v-model="form[weekday][index]['service_leader_id']"
                                    labelClass="!mb-[5px]"
                                    :error="v$.form[weekday][index]['service_leader_id'].$errors[0]?.$message "
                                    @input=" () => { v$.form[weekday][index]['service_leader_id'].$touch(); }"
                                />
                            </div>
                            <div style="width: 19%">
                                <SingleSelect
                                    label="Service Assistant"
                                    :options="service_assistants"
                                    valueKey="id"
                                    placeholder="Service Assistant"
                                    v-model="form[weekday][index]['service_assistant_id']"
                                    labelClass="!mb-[5px]"
                                    :error="v$.form[weekday][index]['service_assistant_id'].$errors[0]?.$message "
                                    @input=" () => { v$.form[weekday][index]['service_assistant_id'].$touch(); }"
                                />
                            </div>
                            <div style="width: 25px" class="self-end mb-2">
                                <TrashIcon v-if="index>0" class="cursor-pointer" @click.prevent="removeSession(weekday, index)" />
                            </div>

                        </div>
                        <!-- <div class="error">
                            Invalid input value
                        </div> -->
                    </div>
                </div>
           </div>
        </div>
    </div>
</template>

<script>

import DownArrow from '@/components/icons/DownArrow.vue'
import UpArrow from '@/components/icons/UpArrow.vue'
import TrashIcon from '@/components/icons/TrashIcon.vue'
import TextInput from '@/components/form/TextInput.vue'
import SingleSelect from "@/components/form/SingleSelect.vue";
import { useVuelidate } from "@vuelidate/core";
import {
  required,
  helpers,
  maxValue,
  integer
} from "@vuelidate/validators";
import {trans} from 'laravel-vue-i18n'

    export default {
        components: {
            DownArrow,
            UpArrow,
            TextInput,
            SingleSelect,
            TrashIcon,
        },
        props: {
            modelValue: {}
        },
        data() {
            return {
                v$: useVuelidate(),
                service_leaders: [],
                service_assistants: [],
                weekdays: [
                    'sunday','monday','tuesday','wednesday','thursday','friday','saturday',
                ],
                selected_weekdays: [],
                weekdaysDropdownOpen: false,
                form: {},
            }
        },
        async created(){
            await this.getAssistantLeader();

            // if(this.$attrs.modelValue && typeof this.$attrs.modelValue == 'object') {
            //    this.form = this.$attrs.modelValue;
            //    this.selected_weekdays = Object.keys(this.$attrs.modelValue)
            // }
        },
        computed : {
            availableWeekDays() {
                return this.weekdays.filter(day=> !this.selected_weekdays.includes(day))
            },
            validationRules() {
                const rules = { }
                this.selected_weekdays.forEach(weekday=> {
                    rules[weekday] = []
                    this.form[weekday].forEach((day, index)=> {
                        rules[weekday][index] = {
                            start_time:  {
                                required: helpers.withMessage(trans('Value required'), required),
                                validTime: helpers.withMessage("Wrong Time format", (value) =>
                                    /^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/.test(value)
                                ),
                            },
                            end_time:  {
                                required: helpers.withMessage(trans('Value required'), required),
                                validTime: helpers.withMessage("Wrong Time format", (value) =>
                                    /^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/.test(value)
                                ),
                            },
                            maximum_occupancy:  {
                                required: helpers.withMessage(trans('Value required'), required),
                                integer: helpers.withMessage("Invalid format", integer),
                            },
                            minimum_occupancy:  {
                                required: helpers.withMessage(trans('Value required'), required),
                                integer: helpers.withMessage("Invalid format", integer),
                            },
                            service_assistant_id:  {
                                required: helpers.withMessage(trans('Value required'), required),
                            },
                            service_leader_id:  {
                                required: helpers.withMessage(trans('Value required'), required),
                            },
                        }
                    })
                })

                return rules
            }
        },
        validations() {
            return {
                form: this.validationRules
            }
        },
        watch: {
            form: {
                handler: function(newVal, oldVal){
                    if (this.v$.$invalid) {
                        this.$emit("update:modelValue", null);
                        this.$emit("changed", null);
                    }else {
                        this.$emit("update:modelValue", newVal);
                        this.$emit("changed", newVal);
                    }
                },
                deep: true
            },
            modelValue: {
                handler: function(newVal, oldVal) {
                    if(newVal && typeof newVal == 'object') {
                        this.form = newVal;
                        this.selected_weekdays = Object.keys(newVal)
                    }
                },
                deep: true
            }
        },
        methods: {
            validInputs() {
                this.v$.$touch();
            },
            addWeekday(weekday) {
                this.form[weekday] = [
                    {
                        start_time: null,
                        end_time: null,
                        minimum_occupancy: null,
                        maximum_occupancy: null,
                        service_leader_id: null,
                        service_assistant_id: null,
                    }
                ]
                this.selected_weekdays.push(weekday)
            },
            removeWeekday(weekday) {
                delete this.form[weekday]
                this.selected_weekdays = this.selected_weekdays.filter(item=>item!=weekday)
            },
            addSession(weekday) {
                this.form[weekday].push(
                    {
                        start_time: null,
                        end_time: null,
                        minimum_occupancy: null,
                        maximum_occupancy: null,
                        service_leader_id: null,
                        service_assistant_id: null,
                    }
                )
            },
            removeSession(weekday, index) {
                this.form[weekday] = this.form[weekday].filter((item, idx)=>index !=idx)
            },
            async getAssistantLeader(){
                try {
                    const {data} = await axios.get(route('service.leader-assistant-dropdown-data'));
                    this.service_leaders = data.leaders
                    this.service_assistants = data.assistants
                } catch (error) {
                    console.log(error)
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .opening_hours_select {
        background: white;
        padding: 24px;
        width: 100%;

        .weekday_selector {
            display: flex;
            gap: 20px;
        }

        .weekdays_dropdown {
            background: #F4F5F5;
            width: 300px;
            position: relative;

            .weekday_dropdown_options {
                position: absolute;
                width: 300px;
                left: 0;
                top: 40;
                background: white;
                filter: drop-shadow(1px 2px 15.2px rgba(78, 78, 78, 0.19));
                li {
                   padding: 10px 18px;
                   border-top: 1px solid #FEF1E7;
                   cursor: pointer;
                   color: var(--Tints-5, #135F84);
                    font-family: Poppins;
                    font-size: 15px;
                    font-style: normal;
                    font-weight: 500;
                    line-height: 20px; /* 133.333% */

                   &:hover {
                    background: #BEE7FB;
                   }
                }
            }
        }

        .selected_weekdays {
            display: flex;
            align-items: center;
            gap: 16px;

            .weekday {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: #2C5B7D;
                color: var(--nutral-black-white-white, #FFF);
                font-family: Poppins;
                font-size: 18px;
                font-style: normal;
                font-weight: 500;
                line-height: normal;
                padding: 4px;
                gap: 6px;
            }
        }

        .weekday_opening_hours {
            &_day {
                margin-top: 20px;

                padding: 16px;
                background: #E9F7FE;
                color: #063F5F;
                font-family: Poppins;
                font-size: 16px;
                font-style: normal;
                font-weight: 600;
                line-height: normal;


                &--header {
                    margin-bottom: 30px;
                    .add_session_btn {
                        background: #16A9B7;
                        padding: 6px 9px;
                        color: var(--nutral-black-white-white, #FFF);
                        font-family: Poppins;
                        font-size: 16px;
                        font-style: normal;
                        font-weight: 500;
                        line-height: normal;
                    }
                }

                &--form {
                    margin-bottom: 20px;
                    .inputs {
                        display: flex;
                        justify-content: space-between;
                    }

                    .error {
                        color: #E97D32;
                    }
                }
            }
        }
    }
</style>
