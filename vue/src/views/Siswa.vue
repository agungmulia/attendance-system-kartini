<template>
    <LoadingView v-if="loading" />
    <div v-else class="md:pl-80 bg-gray-100 flex flex-col flex-1">
        <div
            class="sticky top-0 bg-white z-10 md:hidden px-4 sm:pl-3 py-4 shadow-md"
        >
            <div
                class="flex items-center justify-between text-lg text-blue-900 font-bold"
            >
                <div class="flex items-center">
                    <button
                        type="button"
                        class="-ml-4 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-xl hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-900"
                        @click="sidebarOpen = true"
                    >
                        <span class="sr-only">Open sidebar</span>
                        <Bars3Icon class="h-6 w-6" />
                    </button>
                    <span>Profil</span>
                </div>
                <router-link
                    :to="{ name: 'Profil' }"
                    class="hover:text-blue-800 duration-300"
                    type="button"
                >
                </router-link>
            </div>
        </div>
        <main class="flex-1 pb-6">
            <div>
                <div
                    class="py-6 text-blue-900 bg-white px-10 lg:px-8 shadow-md hidden md:flex justify-between"
                >
                    <span class="font-bold text-xl"> Profil </span>
                </div>
                <div class="max-w-7 pt-6 px-10 lg:px-8">
                    <div class="grid">
                        <form>
                            <div
                                class="py-4 grid lg:flex lg:w-[60%] lg:justify-between space-y-1 rounded-lg shadow-sm bg-white px-4"
                            >
                                <div class="grid">
                                    <span
                                        class="text-blue-900 font-medium text-xl"
                                        >{{ model.nama_siswa }}
                                        <span class="text-green-600"
                                            >({{ model.nis_siswa }})</span
                                        >
                                    </span>
                                    <span class="text-gray-400"
                                        >XII Multimedia 1</span
                                    >
                                    <span class="text-blue-400">{{
                                        model.jenis_kelamin_siswa
                                    }}</span>
                                    <div>
                                        <div class="mt-1">
                                            <span class="text-sm">{{
                                                model.alamat_siswa
                                            }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 md:pt-0">
                                    <span
                                        class="text-blue-900 text-lg font-medium"
                                        >{{ model.email_siswa }}</span
                                    >

                                    <div>
                                        <span>{{ model.no_telp_siswa }}</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="px-10 lg:w-96 lg:px-8 py-6">
                <div
                    class="bg-white rounded-lg shadow-lg px-4 py-4 text-blue-900 font-medium text-md lg:text-lg"
                >
                    <span class="">Persentase Kehadiran</span>
                    <Doughnut
                        class="cursor-pointer"
                        :data="chartData"
                        :ootion="chartOption"
                    />
                    <div
                        v-if="
                            (chartData.datasets[0].data[0] / totalValue()) *
                                100 >
                            75
                        "
                        class="py-4"
                    >
                        <span
                            class="bg bg-green-500 py-2 px-4 rounded-lg text-white text-lg"
                            >Bisa Mengikuti Ujian</span
                        >
                    </div>
                    <div v-else class="py-4 grid justify-items-center">
                        <span
                            class="bg bg-red-500 py-2 px-4 rounded-lg text-white text-md mg:text-lg"
                            >Tidak Bisa Mengikuti Ujian</span
                        >
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
<script>
export default {
    data() {
        return {
            chartOption: {
                responsive: true,
                maintainAspectRatio: false,
            },
        };
    },
    computed: {},
};
</script>

<script setup>
import LoadingView from "../components/LoadingView.vue";
import { Doughnut } from "vue-chartjs";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { sharedConstant } from "../utils";
import { Bars3Icon } from "@heroicons/vue/24/outline";

const sidebarOpen = sharedConstant;
import store from "../store/index.js";
import { useRoute, useRouter } from "vue-router";
import { computed, ref, watch } from "vue";

ChartJS.register(ArcElement, Tooltip, Legend);
const route = useRoute();
const router = useRouter();

const loading = computed(() => store.state.currentSiswa.loading);
const dataSiswa = computed(() => store.state.currentSiswa.data);
watch(
    () => store.state.currentSiswa.data,
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal[0])),
        };
        chartData.value.datasets[0].data[0] = model.value.hadir_siswa;
        chartData.value.datasets[0].data[1] = model.value.izin_siswa;
        chartData.value.datasets[0].data[2] = model.value.alpha_siswa;
    }
);
let model = ref({
    nama_siswa: null,
    jenis_kelamin_siswa: null,
    email_siswa: null,
    no_telp_siswa: null,
    alamat_siswa: null,
    jenis_kelamin_guru: null,
    hadir_siswa: null,
    izin_siswa: null,
    alpha_siswa: null,
});

let chartData = ref({
    labels: ["Hadir", "Izin", "Alpha"],
    datasets: [
        {
            backgroundColor: ["#41B883", "#E46651", "#DD1B16"],
            data: [0, 0, 0],
        },
    ],
});

function totalValue() {
    return this.chartData.datasets[0].data.reduce(
        (acc, value) => acc + value,
        0
    );
}

store.dispatch("showSiswa", route.params.id);
</script>
<style></style>
