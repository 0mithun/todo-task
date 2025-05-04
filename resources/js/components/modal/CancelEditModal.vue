<template>
    <div class="modal-dialog" v-if="show">
        <div class="confirm__modal">
            <div class="confirm__modal--header">
                <h4>{{ $t('Discard changes?') }}</h4>
            </div>
            <div class="confirm__modal--body">
                {{ $t('If you go back or cancel without saving, all changes will be discarded. Are you sure you want to discard the changes?') }}
            </div>
            <div class="confirm__modal--footer">
                <button class="button confirm" @click.prevent="cancel">{{ $t('Yes') }}</button>
                <button class="button cancel" @click.prevent="show = false">{{ $t('No') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return  {
                show: false,
            }
        },
        mounted(){
            this.emitter.on('show-cancel-edit-modal', (e)=> {
                this.show = true;
            })
        },
        methods: {
            cancel() {
                this.show = false
                this.routeName ? this.$router.push({name: this.routeName}) : this.$router.back()
            }
        }
    }
</script>

<style lang="scss" scoped>

.modal-dialog {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;;
    background: rgba(0, 0, 0, 0.5);;
    z-index: 9;
}
     .confirm__modal {
        width: 600px;
        background: #FFFFFF;
        box-shadow: 8px 8px 0px #D3E3EC;
        padding: 24px 32px;
        position: fixed;
        z-index: 9;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        &--header {
            text-align: center;
            margin-bottom: 32px;

            h4 {
                margin: 0;
                padding: 0;

                font-family: 'Poppins';
                font-style: normal;
                font-weight: 700;
                font-size: 18px;
                line-height: 27px;

                color: #16A9B7;
            }
        }

        &--body {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            text-align: center;
            color: #2C5B7D;
        }

        &--footer {
            margin-top: 32px;
            display: flex;
            justify-content: space-between;

            gap: 32px;
            .button {
                width: 50%;
                padding: 8px;

                /* Poppins Bold / 18 */

                font-family: 'Poppins';
                font-style: normal;
                font-weight: 700;
                font-size: 18px;
                line-height: 27px;
                text-align: center;
            }

            .confirm {
                color: #FFFFFF;
                background: #16A9B7;
            }

            .cancel {
                background: #C6E9F2;
                color: #19849E;
            }
        }
    }
</style>
