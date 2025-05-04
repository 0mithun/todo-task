<template>
    <div class="add-new">
        <button class="add_new_btn" @click.prevent="goToEditPage">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M23.9997 13.3333L27.9997 9.33333L22.6663 4L18.6663 8M23.9997 13.3333L10.6663 26.6667H5.33301V21.3333L18.6663 8M23.9997 13.3333L18.6663 8" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
            </svg>

            {{ $t(label) }}
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            routeName: {
                type: String,
                required: true,
            },
            label: {
                type: String,
                default: 'Edit',
            },
        },
        methods: {
            goToEditPage(){
                this.$router.push({ name: this.routeName, params: {id: this.$route.params.id}})
            },
        }
    }
</script>

<style lang="scss" scoped>

    .add-new {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 48px;
        width: 100%;
        .add_new_btn {
            background: #E97D32;
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-size: 18px;
            line-height: 27px;
            text-align: center;
            color: #FFFFFF;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;

            svg {
                margin-right: 10px;
            }

            //background-image: url('data:image/svg+xml,<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.0026 11.3333L24.0026 7.33333L18.6693 2L14.6693 6M20.0026 11.3333L6.66927 24.6667H1.33594V19.3333L14.6693 6M20.0026 11.3333L14.6693 6" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>');
            //background-repeat: no-repeat no-repeat;
            //background-position: 10px center;
            // background-size: cover;
        }
    }
</style>
