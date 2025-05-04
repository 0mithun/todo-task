<template>
     <label
      :for="$attrs.id"
      class="form-label"
      :class="$attrs.labelClass"
      v-if="label"
    >
      <template v-if="typeof $attrs.label == 'object'">
        {{ $t(label.text, label.replace) }}
      </template>
      <template v-else>
        {{ $t(label) }}{{ $attrs.asterisk ? "*" : "" }}
      </template>
    </label>
    <div :class="modelValue ? 'bg-[#118D2C]' : 'bg-[#636363]'" @click="toggle" class="w-[45px] transition-all duration-500 h-[22px] flex items-center rounded-full p-1 hover:cursor-pointer">
        <div :class="{ 'translate-x-6 -ml-[3px]': modelValue }" class="w-[16px] h-[16px] transition-all duration-500 transform bg-white rounded-full shadow-md">
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        label: {
            type: [String, Object],
            required: false,
            default: "",
        },
        modelValue: {
            type: Boolean
        }
    })
    // console.log(props.modelValue)
    const emit = defineEmits(['update:modelValue'])
    function toggle() {
        emit('update:modelValue', !props.modelValue)
    }
</script>

<style scoped>
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
</style>
