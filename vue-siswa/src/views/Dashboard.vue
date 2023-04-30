<template>
    <DefaultPage>
        <template v-slot:header>
            <span class=" font-bold text-xl text-blue-900">Data Siswa</span>
        </template>
        <LoadingView v-if="loading || keteranganAbsensiLoading"/>
        <div v-else class="space-y-4 lg:space-y-0 md:flex md:space-x-4">
         <div
            class="bg-white md:w-[50%] lg:w-[30%] px-4 py-4   rounded-lg shadow-md  text-blue-900 font-medium text-md lg:text-lg"
        >
            <div v-if="hariUpdate(model.updated_at)">Presensi Hari Ini: <span class=" text-gray-500">{{ model.status_presensi }}</span></div>
            <span class="">Persentase Kehadiran</span>
            <Doughnut
                class="cursor-pointer"
                :data="chartData"
                :option="chartOption"
            />
            <div class="text-xs text-gray-400 text-center mt-2">
                Note: Apabila kehadiran dibawah 75% maka siswa
                tidak bisa mengikuti ujian
            </div>
            <div
                v-if="
                    (chartData.datasets[0].data[0] + (0.5 * chartData.datasets[0].data[1]) /
                        totalValue()) *
                    100 >
                    75
                "
                class="py-4 grid justify-items-center"
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

        <div v-if="dataKeteranganAbsensi != null">
            <div class=" bg-white px-10 py-4 w-fit rounded-lg shadow-md">
                <span class=" font-medium text-blue-900">Keterangan Absensi</span>
                <li v-for="(item, index) in dataKeteranganAbsensi" :key="item.id"><span class=" text-xs">{{ item.keterangan_presensi }} ({{
                    new Date(
                        item.updated_at
                    ).toLocaleDateString(
                        "id-ID",
                        {
                            day: "numeric",
                            month: "long",
                            year: "numeric",
                        }
                    )
                }})</span></li>
            </div>
        </div>
        </div>
    </DefaultPage>
</template>

<script setup>
import { PencilIcon } from "@heroicons/vue/24/solid";
import DefaultPage from "../components/DefaultPage.vue";
import LoadingView from "../components/LoadingView.vue";
import AlertView from "../components/AlertView.vue";
import { Doughnut } from "vue-chartjs";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { computed, ref,watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import store from "../store/index.js";
ChartJS.register(ArcElement, Tooltip, Legend);

let chartOption = ref ({
    responsive: true,
        maintainAspectRatio: false,
});
const route = useRoute();
const router = useRouter();
store.dispatch("getDataAbsen");
store.dispatch("getKeteranganAbsensi");
const dataKeteranganAbsensi = computed(() => store.state.keterangan_absensi.data);
const absenData = computed(() =>store.state.absen.data);
const loading = computed(() =>store.state.absen.loading);
const keteranganAbsensiLoading = computed(() => store.state.keterangan_absensi.loading);
let model = ref({
    updated_at:null,
    status_presensi:null,
    total_hadir_presensi: null,
    total_izin_presensi: null,
    total_alpha_presensi: null,
});
watch(
    () => store.state.absen.data[0],
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };
        chartData.value.datasets[0].data[0] = model.value.total_hadir_presensi;
        chartData.value.datasets[0].data[1] = model.value.total_izin_presensi;
        chartData.value.datasets[0].data[2] = model.value.total_alpha_presensi;
    }
);
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
function hariUpdate(value) {
    let lastUpdate = new Date(value);
    let hariIni = new Date();
    return hariIni.toDateString() == lastUpdate.toDateString();
}
</script>
<style></style>
