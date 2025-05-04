<template>
    <div :class="`my-2 h-auto px-3 rounded-[100px] justify-start items-center gap-2 inline-flex ${bg}`">
        <div class="text-center text-[#093e60] text-xs font-normal font-['Poppins'] capitalize leading-[30px]">{{ $t(title) }}</div>
    </div>
</template>
<script setup>

defineProps({
    title: String,
    bg: {
        type: String,
        default: 'bg-[#c1ffc3]'
    }
})
</script>