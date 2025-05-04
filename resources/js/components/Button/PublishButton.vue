<template>
    <button class="publish_button">
        <slot>
            {{ $t("Publish") }}
        </slot>
    </button>
</template>


<style lang="scss">
    .publish_button {
        width: 100%;
        height: 40px;
        text-align: center;
        background: #BEE7FB;
        color: #093E60;
        text-align: center;

        /* Nexa Bold / 18 */
        font-family: Nexa;
        font-size: 18px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }
</style>
