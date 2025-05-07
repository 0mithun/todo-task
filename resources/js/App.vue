<template>
    <div>
        <router-view></router-view>
    </div>
    <SuccessNotification />
    <FailNotification />
</template>


<script setup>
import SuccessNotification from '@/components/Notification/SuccessNotification.vue'
import FailNotification from '@/components/Notification/FailNotification.vue'

</script>
