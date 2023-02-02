<!--
  This example requires Tailwind CSS v2.0+ 
  
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<template>
    <!--
    This example requires updating your template:

    ```
    <html class="h-full bg-white">
    <body class="h-full">
    ```
  -->
    <div class="h-screen w-full bg-red-700 lg:bg-gray-100">
        <LoadingView v-if="loading" />
        <div v-else>
            <div
                class="min-h-full justify-center flex lg:px-20 xl:px-24 lg:pt-8 xl:pt-10"
            >
                <div
                    class="flex-1 flex flex-col xl:rounded-l-xl bg-red-700 py-10 px-4 sm:px-6 lg:flex-none"
                >
                    <div class="mx-auto w-full max-w-sm lg:w-96">
                        <div class="grid justify-items-center">
                            <img
                                class="h-12 w-auto"
                                src="../assets/SMKKartiniLogo.png"
                            />
                            <h2 class="mt-6 text-2xl font-extrabold text-white">
                                Sign in to your account
                            </h2>
                            <span class="mt-2 text-lg text-white">
                                Contact your
                                {{ " " }}
                                <a
                                    href="#"
                                    class="font-medium text-gray-900 hover:text-blue-900"
                                >
                                    admin
                                </a>
                                for more info
                            </span>
                        </div>

                        <div
                            class="mt-8 mx-5 lg:mx-8 bg-white px-6 text-xs pb-6 pt-2 rounded-xl shadow-lg"
                        >
                            <div class="mt-6">
                                <div
                                    v-if="errorMsg"
                                    class="text-white px-2 mb-2 py-2 items-center justify-between flex max-w-sm bg-red-900 rounded-lg"
                                >
                                    {{ errorMsg }}
                                    <span @click="errorMsg = ''"
                                        ><XCircleIcon
                                            class="h-6 w-6 cursor-pointer rounded-full duration-300 hover:bg-red-700"
                                    /></span>
                                </div>
                                <form @submit="login" class="space-y-6">
                                    <div>
                                        <label
                                            for="email"
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Email address
                                        </label>
                                        <div class="mt-1">
                                            <input
                                                v-model="user.email"
                                                id="email"
                                                name="email"
                                                type="email"
                                                autocomplete="email"
                                                required=""
                                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <label
                                            for="password"
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Password
                                        </label>
                                        <div class="mt-1">
                                            <input
                                                v-model="user.password"
                                                id="password"
                                                name="password"
                                                :type="passwordType"
                                                autocomplete="current-password"
                                                required=""
                                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                            />
                                        </div>
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <div class="space-x-1">
                                                <input
                                                    v-model="user.remember"
                                                    id="remember"
                                                    name="remember"
                                                    type="checkbox"
                                                    class="text-red-900 border-gray-400 rounded-md focus:ring-transparent"
                                                />
                                                <span
                                                    for="remember"
                                                    class="h-4 w-4 text-xs"
                                                    >Remember me</span
                                                >
                                            </div>
                                            <div class="flex items-center">
                                                <button
                                                    type="button"
                                                    class="text-xs space-x-2 flex items-center"
                                                    @click="lihatPasswordFunc"
                                                >
                                                    <EyeOffIcon
                                                        :size="20"
                                                        v-if="
                                                            passwordType ===
                                                            'password'
                                                        "
                                                    />
                                                    <EyeOpenIcon
                                                        :size="20"
                                                        v-else
                                                    />
                                                    <span>
                                                        Lihat Password
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <button
                                            type="submit"
                                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        >
                                            Sign in
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:block relative w-[50%]">
                    <div
                        class="border-2 border-gray-300 rounded-r-lg px-8 py-8 w-full h-full"
                    >
                        <img
                            class="h-full w-full object-cover rounded-xl"
                            src="https://i.ibb.co/yWnBKv3/277669352-658791575076572-5512915566654719741-n.jpg"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </div>
        <div
            class="bg-red-700 absolute text-white grid lg:flex lg:justify-between justify-items-center inset-x-0 bottom-0 w-full lg:h-20 py-6 lg:px-20 space-y-4 lg:space-y-0"
        >
            <div class="grid justify-items-center lg:flex">
                <span>Copyright © 2022 SMK Kartini Batam.</span>
                <span>All rights reserved.</span>
            </div>

            <div class="flex space-x-6">
                <InstagramIcon />
                <FacebookIcon />
                <GmailIcon />
            </div>
        </div>
    </div>
</template>

<script>
import LoadingView from "../components/LoadingView.vue";
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/20/solid";
import { XCircleIcon } from "@heroicons/vue/24/outline";
import InstagramIcon from "vue-material-design-icons/Instagram.vue";
import FacebookIcon from "vue-material-design-icons/Facebook.vue";
import GmailIcon from "vue-material-design-icons/Gmail.vue";
import EyeOpenIcon from "vue-material-design-icons/Eye.vue";
import EyeOffIcon from "vue-material-design-icons/EyeOff.vue";
export default {
    components: {
        InstagramIcon,
        FacebookIcon,
        GmailIcon,
        EyeOpenIcon,
        EyeOffIcon,
    },
    data() {
        return {
            passwordType: "password",
        };
    },
    methods: {
        lihatPasswordFunc() {
            this.passwordType =
                this.passwordType === "password" ? "text" : "password";
        },
    },
};
</script>
<script setup>
import store from "../store/index.js";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();
const user = {
    email: "",
    password: "",
    remember: false,
};

let loading = ref(false);
let errorMsg = ref("");

function login(ev) {
    ev.preventDefault();

    loading.value = true;
    store
        .dispatch("login", user)
        .then(() => {
            router.push({
                name: "Dashboard",
            });
        })
        .catch((err) => {
            loading.value = false;
            errorMsg.value = err.response.data.error;
        });
}
</script>
