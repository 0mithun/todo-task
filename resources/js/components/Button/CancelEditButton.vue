<template>
  <button class="cancel_button" @click="cancel">
    {{ $t("Cancel") }}
  </button>
</template>

<script>
export default {
    props: {
        routeName: {
            type: String,
            default: null
        },
        body: {
            type: String,
            default: '',
        },
        title: {
            type: String,
            default: '',
        },
    },
    methods: {
        cancel() {
            this.emitter.emit('show-cancel-edit-modal', {
                title: this.title,
                body: this.body,
                routeName: this.routeName
            })
        }
    }
}
</script>


<style lang="scss" scoped>

    .cancel_button {
        width: 100%;
        background: #F8D3BA;
        height: 40px;
        text-align: center;
        cursor: pointer;

        color: var(--1-4, #2C5B7D);
        text-align: center;

        /* Nexa Bold / 18 */
        font-family: Nexa;
        font-size: 18px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

</style>
