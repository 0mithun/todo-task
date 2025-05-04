<template>
    <div class="input-element w-full" :class="$attrs.wrapperClass">
        <TextInput
            id="map_address_input"
            :label="label"
            :asterisk="$attrs.asterisk"
            :placeholder="placeholder"
            v-model="formatted_address"
            @input="change"
            :error="error"
        />
        <p
            class="error-box flex p-0 items-center gap-2 mt-[4px] text-error text-12"
            v-if="(typeof error == 'string' && error) && showError"
        >
            {{ $t(error) }}
        </p>
    </div>

</template>

<script>
import TextInput from "@/components/form/TextInput.vue";
    export default {
        props: {
            label: {
                type: [String, Object],
                required: false,
                default: ''
            },
            placeholder: {
                type: String,
                default: ''
            },
            defaultValue: {
                type: String,
                default: null
            },
            error: {
                type: [Boolean, String],
                required: false
            },
            showError: {
                type: Boolean,
                default: false
            }
        },
        components: {
            TextInput
        },
        watch: {
            defaultValue(newVal,olVal) {
                this.formatted_address = newVal
            }
        },
        data(){
            return {
                formatted_address: this.defaultValue,
            }
        },
        mounted(){
            const autocomplete = new google.maps.places.Autocomplete(map_address_input, {
                // fields: ["geometry"],
                strictBounds: false,
            });

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                this.setPlace(place)
            });
        },
        methods: {
            change(e) {
                this.$emit('input_address', e.target.value)
            },
            setPlace(event){
                const address = this.getAddress(event)
                this.$emit('address_selected', address)
            },
            getAddress(event) {
                const address = {
                    lat: event.geometry.location.lat(),
                    lng: event.geometry.location.lng(),
                    formatted_address: event.formatted_address,
                    street_name: null,
                    street_number: null,
                    zip_code: null,
                    city: null,
                    country: null,
                }
                event.address_components.forEach(element => {
                    if(element.types.includes('street_number')) {
                        address.street_number = element.long_name
                    }
                    if(element.types.includes('route')) {
                        address.street_name = element.long_name
                    }
                    if(element.types.includes('sublocality')) {
                        address.city = element.long_name
                    }
                    if(element.types.includes('locality')) {
                        address.city = element.long_name
                    }
                    if(element.types.includes('postal_code')) {
                        address.zip_code = element.long_name
                    }
                    if(element.types.includes('country')) {
                        address.country = element.short_name
                    }
                });

                return address
            }
        }
    }
</script>


<style lang="scss">

.form-label {
    color: var(--Primary-Ball-Blue, #16A9B7);
    font-family: Poppins;
    font-size: 18px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;

    margin-bottom: 12px;
    display: inline-block;
}


.google-map-autocomplete{
    width: 100%;
    background: #FFF;
    border: none;
    outline: none;

    color: #063F5F;
    font-family: Poppins;
    font-size: 15px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;


    height: 40px;
    padding: 14px 24px;

    &:focus {
        outline: none;
        border: none;
    }

    &::placeholder {
        color: var(--1-2, #87B1CB);
        font-family: Nexa;
        font-size: 15px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }
}

.border-error {
    border: 1px solid #E97D32;
}
</style>
