<template>
 <svg :width="width" :height="height" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="16" cy="16" r="16" :fill="circleFill"/>
<path d="M9 23C10.0182 14.5321 21.4727 13.5644 23 23H9Z" :fill="avatarFill"/>
<path d="M19.6909 11.6289C19.6909 13.6332 17.9815 15.2579 15.8727 15.2579C13.764 15.2579 12.0545 13.6332 12.0545 11.6289C12.0545 9.62474 13.764 8 15.8727 8C17.9815 8 19.6909 9.62474 19.6909 11.6289Z" :fill="avatarFill"/>
</svg>


</template>

<script>
    export default {
        props: {
            width: {
                type: Number,
                default: 32
            },
            height: {
                type: Number,
                default: 32
            },
            circleFill: {
                type: String,
                default: '#939393'
            },
            avatarFill: {
              type: String,
                default: '#F3F9FF'
            },
        }
    }
</script>

<style lang="scss" scoped>

</style>
