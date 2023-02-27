<template>
    <DefaultPage pageHeading="Kelas Anda">
        <LoadingView v-if="loading" />
        <div
            v-else
            class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4"
        >
            <router-link
                v-for="(item, itemIdx) in navigation"
                :to="item.name"
                :key="item.name"
                :style="{
                    animationDelay: `${itemIdx * 0.1}s`,
                }"
                class="bg-gray-200 animate-fade-in-right hover:bg-gray-300 duration-200 rounded-lg px-4 py-4 shadow-sm"
            >
                <div class="flex items-center">
                    <component
                        :is="item.icon"
                        class="mr-3 flex-shrink-0 h-6 w-6 text-blue-900"
                        aria-hidden="true"
                    />
                    <div class="grid">
                        <span>Kelola {{ item.name }}</span>
                        <span class="text-xs text-gray-500"
                            >Jumlah {{ item.name }}:
                            <span v-if="itemIdx == 0">{{
                                dashboardData.total_guru
                            }}</span
                            ><span v-else-if="itemIdx == 1">{{
                                dashboardData.total_siswa
                            }}</span
                            ><span v-else-if="itemIdx == 2">{{
                                dashboardData.total_kelas
                            }}</span
                            ><span v-else-if="itemIdx == 3">{{
                                dashboardData.total_sesi
                            }}</span
                            ><span v-else-if="itemIdx == 4">{{
                                dashboardData.total_jadwal
                            }}</span></span
                        >
                    </div>
                </div>
            </router-link>
        </div>
    </DefaultPage>
</template>

<script setup>
import { PencilIcon } from "@heroicons/vue/24/solid";
import DefaultPage from "../components/DefaultPage.vue";
import LoadingView from "../components/LoadingView.vue";
import AlertView from "../components/AlertView.vue";
import CalendarIcon from "vue-material-design-icons/Calendar.vue";
import ChartBarIcon from "vue-material-design-icons/ChartBar.vue";
import HumanMaleBoardIcon from "vue-material-design-icons/HumanMaleBoard.vue";
import AccountTie from "vue-material-design-icons/AccountTie.vue";
import ClockIcon from "vue-material-design-icons/Clock.vue";
import HomeIcon from "vue-material-design-icons/HomeOutline.vue";
import HomeAccountIcon from "vue-material-design-icons/HomeAccount.vue";
import MenuIcon from "vue-material-design-icons/Menu.vue";
import { computed, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import store from "../store/index.js";

const loading = computed(() => store.state.dashboard.loading);
const dashboardData = computed(() => store.state.dashboard.data);

const route = useRoute();

const router = useRouter();

const today = ref(false);

const navigation = [
    {
        name: "Guru",
        icon: HumanMaleBoardIcon,
    },
    {
        name: "Siswa",
        icon: AccountTie,
    },
    {
        name: "Kelas",
        icon: HomeAccountIcon,
    },
    {
        name: "Sesi",
        icon: ClockIcon,
    },
    {
        name: "Jadwal",
        icon: CalendarIcon,
    },
];

store.dispatch("getDashboardData");
</script>
<style></style>
