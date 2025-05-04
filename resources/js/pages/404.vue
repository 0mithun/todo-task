<template>
    <div class="container">
        <div class="left">
            <div class="number_text">
                <h2
                    class="text-[156px] text-[#7D3272] font-semibold font-poppins leading-8"
                >
                    404
                </h2>
            </div>
            <div class="pt-20 pb-8">
                <h2
                    class="text-[39px] text-[#C59BBF] font-semibold font-poppins"
                >
                    {{ $t("Page not found") }}
                </h2>
            </div>
            <div class="pb-10">
                <p class="text-[25px] text-[#636363] font-normal font-poppins">
                    {{
                        $t(
                            "Sorry, we can't find the page you are looking for, because it is not or no longer valid."
                        )
                    }}
                </p>
            </div>
            <ButtonGradient
                @click="goBackOrLogin()"
                type="button"
                class="w-3/5 mt-4"
            >
                {{ $t("Back to main page") }}
            </ButtonGradient>
        </div>
    </div>
</template>

<script setup>
import { useRouter, useRoute } from "vue-router";

const router = useRouter();

const goBackOrLogin = () => {
    if (window.history.length > 1) {
        router.go(-1); // Go back to the previous page in history
    } else {
        router.push({ name: "login" }); // Navigate to the login page
    }
};
</script>

<style lang="scss" scoped>
.container {
    display: flex;
    flex-wrap: wrap;
    margin: 0 auto;
    width: 1100px;
    margin-top: 10%;
}

.left {
    width: 50%;
    margin-top: 10%;
}

.right {
    width: 50%;
}
</style>
