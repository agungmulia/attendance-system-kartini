<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <!--
    This example requires updating your template:

    ```
    <html class="h-full bg-gray-100">
    <body class="h-full">
    ```
  -->
    <div class="h-screen bg-gray-100">
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog
                as="div"
                class="fixed inset-0 flex z-40 md:hidden"
                @close="sidebarOpen = false"
            >
                <TransitionChild
                    as="template"
                    enter="transition-opacity ease-linear duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="transition-opacity ease-linear duration-300"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay
                        class="fixed inset-0 bg-gray-600 bg-opacity-75"
                    />
                </TransitionChild>
                <TransitionChild
                    as="template"
                    enter="transition ease-in-out duration-300 transform"
                    enter-from="-translate-x-full"
                    enter-to="translate-x-0"
                    leave="transition ease-in-out duration-300 transform"
                    leave-from="translate-x-0"
                    leave-to="-translate-x-full"
                >
                    <div
                        class="relative flex-1 flex flex-col max-w-xs w-full bg-red-700"
                    >
                        <TransitionChild
                            as="template"
                            enter="ease-in-out duration-300"
                            enter-from="opacity-0"
                            enter-to="opacity-100"
                            leave="ease-in-out duration-300"
                            leave-from="opacity-100"
                            leave-to="opacity-0"
                        >
                            <div class="absolute top-0 right-0 -mr-12 pt-2">
                                <button
                                    type="button"
                                    class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                    @click="sidebarOpen = false"
                                >
                                    <span class="sr-only">Close sidebar</span>
                                    <XIcon
                                        class="h-6 w-6 text-white"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                        </TransitionChild>
                        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                            <div
                                class="flex items-center flex-shrink-0 px-4 space-x-2"
                            >
                                <img
                                    class="h-8 w-auto"
                                    src="../assets/SMKKartiniLogo.png"
                                    alt="Workflow"
                                />
                                <span class="text-white text-base font-bold"
                                    >Kartini Attendance System</span
                                >
                            </div>

                            <nav class="mt-5 px-2 space-y-1">
                                <router-link
                                    v-for="item in navigation"
                                    :key="item.name"
                                    :to="item.to"
                                    active-class="bg-red-800 text-white"
                                    :class="[
                                        this.$route.name === item.to.name
                                            ? ''
                                            : 'text-white duration-200 hover:bg-red-600 hover:bg-opacity-75',
                                        'group flex items-center px-2 py-2 text-base font-medium rounded-md',
                                    ]"
                                >
                                    <component
                                        :is="item.icon"
                                        class="mr-4 flex-shrink-0 h-6 w-6 text-red-300"
                                        aria-hidden="true"
                                    />
                                    {{ item.name }}
                                </router-link>
                            </nav>
                        </div>
                        <div
                            class="flex-shrink-0 flex border-t duration-200 hover:bg-red-500 bg-red-600 border-red-800 p-4"
                        >
                            <a
                                @click="logout"
                                class="flex-shrink-0 w-full group block cursor-pointer"
                            >
                                <div
                                    class="flex justify-center space-x-3 items-center"
                                >
                                    <PowerIcon class="h-6 w-6 text-white" />
                                    <span class="text-white text-lg">
                                        Log Out
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </TransitionChild>
                <div class="flex-shrink-0 w-14" aria-hidden="true">
                    <!-- Force sidebar to shrink to fit close icon -->
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-80 md:flex-col md:fixed md:inset-y-0">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex-1 flex flex-col min-h-0 bg-red-700">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4 space-x-2">
                        <img
                            class="h-8 w-auto"
                            src="../assets/SMKKartiniLogo.png"
                            alt="Workflow"
                        />
                        <span class="text-white text-base font-bold"
                            >Kartini Attendance System</span
                        >
                    </div>
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <router-link
                            v-for="item in navigation"
                            :key="item.name"
                            :to="item.to"
                            active-class="bg-red-800 text-lg text-white"
                            :class="[
                                this.$route.name === item.to.name
                                    ? ''
                                    : 'text-white text-lg duration-300 hover:bg-red-600  hover:bg-opacity-75',
                                'group flex items-center px-2 py-2 text-sm font-medium rounded-md',
                            ]"
                        >
                            <component
                                :is="item.icon"
                                class="mr-3 flex-shrink-0 h-6 w-6 text-red-300"
                                aria-hidden="true"
                            />
                            {{ item.name }}
                        </router-link>
                    </nav>
                </div>
                <div
                    class="flex-shrink-0 flex border-t bg-red-600 duration-200 hover:bg-red-500 border-red-800 p-4"
                >
                    <a
                        @click="logout"
                        class="flex-shrink-0 w-full group block cursor-pointer"
                    >
                        <div class="flex justify-center space-x-3 items-center">
                            <PowerIcon class="h-6 w-6 text-white" />
                            <span class="text-white text-lg"> Log Out </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <router-view></router-view>
    </div>
    <NotificationView />
</template>

<script>
import { sharedConstant } from "../utils";
import { useRouter } from "vue-router";
import NotificationView from "./NotificationView.vue";
import store from "../store/index.js";

import {
    Dialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";

import { Bars3Icon, PowerIcon } from "@heroicons/vue/24/outline";

import CalendarIcon from "vue-material-design-icons/Calendar.vue";
import ChartBarIcon from "vue-material-design-icons/ChartBar.vue";
import HumanMaleBoardIcon from "vue-material-design-icons/HumanMaleBoard.vue";
import AccountTie from "vue-material-design-icons/AccountTie.vue";
import ClockIcon from "vue-material-design-icons/Clock.vue";
import HomeIcon from "vue-material-design-icons/HomeOutline.vue";
import HomeAccountIcon from "vue-material-design-icons/HomeAccount.vue";
import MenuIcon from "vue-material-design-icons/Menu.vue";
import XIcon from "vue-material-design-icons/Close.vue";

const navigation = [
    {
        name: "Dashboard",
        to: { name: "Dashboard" },
        icon: HomeIcon,
        current: true,
    },
    {
        name: "Guru",
        to: { name: "Guru" },
        icon: HumanMaleBoardIcon,
        current: false,
    },
    {
        name: "Siswa",
        to: { name: "Siswa" },
        icon: AccountTie,
        current: false,
    },
    {
        name: "Kelas",
        to: { name: "Kelas" },
        icon: HomeAccountIcon,
        current: false,
    },
    {
        name: "Sesi",
        to: { name: "Sesi" },
        icon: ClockIcon,
        current: false,
    },
    {
        name: "Jadwal",
        to: { name: "Jadwal" },
        icon: CalendarIcon,
        current: false,
    },
];

export default {
    components: {
        Dialog,
        PowerIcon,
        Bars3Icon,
        DialogOverlay,
        TransitionChild,
        TransitionRoot,
        MenuIcon,
        XIcon,
        NotificationView,
    },
    setup() {
        const sidebarOpen = sharedConstant;
        const router = useRouter();

        function logout() {
            store.commit("logout");
            router.push({
                name: "Login",
            });
        }

        return {
            navigation,
            sidebarOpen,
            logout,
        };
    },
};
</script>
