<template>
    <div class="language__switches">

        <div class="language__switches--item" :class="{active: option.lang == 'de'}">
            <button @click.prevent="setLang('de')">DE</button>
        </div>
        <div class="language__switches--item" :class="{active: option.lang == 'en'}">
            <button  @click.prevent="setLang('en')">EN</button>
        </div>
        <!-- <div class="language__switches--item" :class="{active: option.lang == 'fr'}">
            <button  @click.prevent="setLang('fr')">FR</button>
        </div>
        <div class="language__switches--item" :class="{active: option.lang == 'it'}">
            <button @click.prevent="setLang('it')">IT</button>
        </div> -->
    </div>
</template>

<script>
import { loadLanguageAsync, trans } from "laravel-vue-i18n";
import { reactive } from "@vue/reactivity";
import { useUserStore } from "@/store/user";
import axios from 'axios';
import { useRoute } from 'vue-router';


export default {
    setup(props, {emit}){
            const vRoute = useRoute()
            const userStore = useUserStore();

            const option = reactive({
                lang: userStore.user.language ?? localStorage.getItem('lang') ??  'de'
            });

            const setLang = async (lang) => {
                localStorage.setItem('lang', lang);
                option.lang = lang;

                if(userStore.user) {
                    await axios.put(route('user.language-update'), {language: lang})
                }

                await loadLanguageAsync(lang);
                emit('changeLanguage', lang)

                await userStore.fetchUser()
                document.title = `LetsPlan: ${trans(vRoute.meta.title?? '')}`;
            }

            return {
                setLang,
                option
            }
        }
    }
</script>

<style lang="scss" scoped>
    .language__switches {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-bottom: 10px;

        &--item {
            button {
                border: 0;
                outline: 0;
                width: 40px;
                height: 40px;
                border-radius: 5px;
                background: #FFFFFF;

                font-family: 'Montserrat';
                font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 24px;
                color: #5D5D60;
                cursor: pointer;
            }
        }
        &--item.active {
            button {
                background: #E97D32;
                color: #FFFFFF;
                font-weight: 700;
            }
        }
    }
</style>
