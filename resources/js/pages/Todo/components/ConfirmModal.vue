<template>
    <div class="modal-dialog">
        <div class="confirm__modal relative" v-if="showModal">
            <div class="confirm__modal--header">
                <h4>{{ title }}</h4>
            </div>
            <div class="confirm__modal--body">
                {{ body }}
            </div>
            <div class="confirm__modal--footer">
                <button class="button confirm" @click.prevent="changeStatus">{{ $t('Yes') }}</button>
                <button class="button cancel" @click.prevent="$emit('close')">{{ $t('No') }}</button>
            </div>

            <div class="close-icon absolute right-3 top-3">
                <CloseIcon
                    class="cursor-pointer"
                    @click.prevent="$emit('close')"
                ></CloseIcon>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import {trans} from 'laravel-vue-i18n'
    import CloseIcon from "@/components/icons/CloseIconLarge.vue";
    export default {
        props: {
            company: {
                type: Object,
                required: true
            }
        },
        components: {
            CloseIcon
        },
        data(){
            return  {
                showModal: true,
                status_id: null,
            }
        },
        computed: {
            title(){
                return this.company.status == 'active'  ? trans('Deactivate institute?') : trans('Activate institute?');
            },
            body(){
                return this.company.status == 'active' ? trans('Are you sure you really want to deactivate the institute :name?', {name: this.company.name}) : trans('Are you sure you really want to activate the institute :name?', {name: this.company.name})
            }
        },
        mounted(){
            // EventBus.$on('show-confirm-modal', (e)=>{
            //     this.status_id = e.status
            //     this.company = e.company
            //     this.showModal = true;
            // })
        },
        methods: {
            async changeStatus(){
                try {
                    const status = this.company.status == 'active' ? 'inactive': 'active';
                    const res = await axios.put(route('company.status-update', { company: this.company.id, status}))


                    const message = this.company.status == 'active' ?  trans('The institute :name has been successfully deactivated.', {name: this.company.name}) : trans('The institute :name has been successfully activated.', {name: this.company.name})
                    this.emitter.emit(`update-status-${this.company.id}`, status);
                    this.emitter.emit(`show-success-notification`, message);

                    this.$emit('close')
                } catch (error) {
                    console.log(error)
                }
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
